<?php

namespace App\Http\Controllers;

use App\Models\DonateBlood;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DonorController extends Controller
{
    public function showDonationPage()
    {
        return view('donate_blood');
    }

    public function checkEligibility()
    {
        $lastDonation = DonateBlood::where('user_id', auth()->id())
            ->whereIn('status', ['approved', 'pending'])
            ->where('donation_date', '>=', now()->subMonths(3))
            ->first();

        return response()->json([
            'eligible' => !$lastDonation,
            'next_donation_date' => $lastDonation ? $lastDonation->donation_date->addMonths(3) : null
        ]);
    }

    public function findAdminsBtn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $admins = Admin::select(['id', 'name', 'latitude', 'longitude'])->get()
            ->map(function ($admin) use ($request) {
                $admin->distance = $this->calculateDistance(
                    $request->latitude,
                    $request->longitude,
                    $admin->latitude,
                    $admin->longitude
                );
                return $admin;
            })
            ->sortBy('distance')
            ->values();

        return response()->json($admins);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    public function submitDonation(Request $request)
    {
        $lastDonation = DonateBlood::where('user_id', auth()->id())
            ->where('status', ['approved', 'pending'])
            ->where('donation_date', '>=', now()->subMonths(3))
            ->first();

        if ($lastDonation) {
            return response()->json([
                'success' => false,
                'message' => 'You can only donate blood once every 3 months. Your last donation was on ' .
                    $lastDonation->donation_date->format('M d, Y')
            ], 422);
        }

        $validated = $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'blood_type' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'blood_quantity' => 'required|integer|min:1|max:2',
            'request_form' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        try {
            if ($request->hasFile('request_form')) {
                $imageName = time().'.'.$request->file('request_form')->getClientOriginalExtension();
                $request->file('request_form')->move(public_path('assets/donor_proofs'), $imageName);
                $validated['request_form'] = 'assets/donor_proofs/'.$imageName;
            }

            $validated['user_id'] = auth()->id();
            $validated['status'] = 'pending';
            $validated['donation_date'] = now();

            DonateBlood::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Donation request submitted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Donation submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error submitting donation request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function status()
    {
        $donations = DonateBlood::with('admin')
            ->where('user_id', auth()->id())
            ->latest('donation_date')
            ->get();

        $eligibility = $this->checkEligibility(auth()->id());

        return view('donor_status', compact('donations', 'eligibility'));
    }

    public function edit($id)
    {
        $donation = DonateBlood::with('admin')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        abort_unless($donation->canEdit(), 403, 'Cannot edit completed or cancelled donations');

        return view('edit_donation', [
            'donation' => $donation,
            'currentFileUrl' => $donation->file_url
        ]);
    }

    public function update(Request $request, $id)
    {
        $donation = DonateBlood::where('user_id', auth()->id())
            ->findOrFail($id);

        abort_unless($donation->canEdit(), 403, 'Cannot update this donation');

        $validated = $request->validate([
            'blood_quantity' => 'required|integer|min:1|max:2',
            'request_form' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        try {
            if ($request->hasFile('request_form')) {
                if ($donation->request_form && file_exists(public_path($donation->request_form))) {
                    File::delete(public_path($donation->request_form));
                }

                $file = $request->file('request_form');
                $fileName = 'donation_'.time().'_'.auth()->id().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('assets/donor_proofs'), $fileName);
                $validated['request_form'] = 'assets/donor_proofs/'.$fileName;
            }

            $donation->update($validated);
            return redirect()->route('donor.status')->with('success', 'Donation updated successfully');

        } catch (\Exception $e) {
            Log::error("Donation update failed: ".$e->getMessage());
            return back()->with('error', 'Failed to update donation');
        }
    }

    public function destroy(DonateBlood $donation)
    {
        if ($donation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($donation->status !== 'pending') {
            return redirect()->route('donor.status')
                ->with('error', 'Only pending donations can be deleted');
        }

        try {
            if ($donation->request_form && file_exists(public_path($donation->request_form))) {
                unlink(public_path($donation->request_form));
            }

            $donation->delete();

            return redirect()->route('donor.status')
                ->with('success', 'Donation request deleted successfully');

        } catch (\Exception $e) {
            Log::error('Donation deletion failed: ' . $e->getMessage());
            return redirect()->route('donor.status')
                ->with('error', 'Failed to delete donation: ' . $e->getMessage());
        }
    }

}
