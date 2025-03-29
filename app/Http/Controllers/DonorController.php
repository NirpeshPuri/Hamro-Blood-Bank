<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\DonateBlood;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DonorController extends Controller
{
    public function showDonationPage()
    {
        return view('donate_blood');
    }

    public function findAdminsBtn(Request $request)
    {
        $userLat = $request->input('latitude');
        $userLng = $request->input('longitude');

        // Fetch all admins
        $admins = Admin::all();

        // Calculate distance for each admin
        $adminsWithDistance = $admins->map(function ($admin) use ($userLat, $userLng) {
            $distance = $this->calculateDistance($userLat, $userLng, $admin->latitude, $admin->longitude);
            $admin->distance = $distance;
            return $admin;
        });

        // Sort admins by distance
        $sortedAdmins = $adminsWithDistance->sortBy('distance');

        return response()->json($sortedAdmins->values());
    }

    // Function to calculate distance using Haversine formula
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius of the earth in kilometers

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
        $validated = $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'blood_type' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'blood_quantity' => 'required|integer|min:1|max:10',
            'request_form' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('request_form')) {
                $file = $request->file('request_form');
                $filename = 'donation_' . time() . '_' . auth()->id() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('donor_proofs', $filename, 'public');
                $validated['request_form'] = $path;
            }

            // Add additional data
            $validated['user_id'] = auth()->id();
            $validated['status'] = 'pending';

            // Create donation record
            DonateBlood::create($validated);

            // TODO: Send notification to blood bank admin

            return response()->json([
                'success' => true,
                'message' => 'Donation request submitted successfully. The blood bank will contact you soon.'
            ]);

        } catch (\Exception $e) {
            Log::error('Donation submission error: ' . $e->getMessage());

            // Delete uploaded file if error occurred
            if (isset($path)){ Storage::disk('public')->delete($path);}

            return response()->json([
                'success' => false,
                'message' => 'Error submitting donation request. Please try again.'
            ], 500);
        }
    }
}
