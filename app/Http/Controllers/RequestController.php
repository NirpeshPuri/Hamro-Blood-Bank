<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\DonateBlood;
use App\Models\BloodBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    // Show admin dashboard with receiver requests
    public function adminDashboard()
    {
        $receiverRequests = BloodRequest::with(['user', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_dashboard', compact('receiverRequests'));
    }

    // Show donor requests (separate page)
    public function donorRequests()
    {
        $donorRequests = DonateBlood::with(['user', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.donor_request', compact('donorRequests'));
    }

    // Update receiver request status
    public function updateReceiverStatus(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $bloodRequest = BloodRequest::findOrFail($id);

            $validated = $request->validate([
                'status' => 'required|in:Approved,Rejected,Pending',
                'payment' => 'nullable|numeric'
            ]);

            $bloodBank = BloodBank::where('admin_id', auth()->id())->first();

            if ($validated['status'] == 'Approved' && $bloodRequest->status != 'Approved') {
                if (!$bloodBank) {
                    return back()->with('error', 'Blood bank record not found');
                }

                $currentQuantity = $bloodBank->{$bloodRequest->blood_group} ?? 0;

                if ($currentQuantity < $bloodRequest->blood_quantity) {
                    return back()->with('error', 'Not enough blood in stock');
                }

                $bloodBank->{$bloodRequest->blood_group} = $currentQuantity - $bloodRequest->blood_quantity;
                $bloodBank->save();
            }
            elseif ($bloodRequest->status == 'Approved' && $validated['status'] != 'Approved') {
                if ($bloodBank) {
                    $currentQuantity = $bloodBank->{$bloodRequest->blood_group} ?? 0;
                    $bloodBank->{$bloodRequest->blood_group} = $currentQuantity + $bloodRequest->blood_quantity;
                    $bloodBank->save();
                }
            }

            $bloodRequest->update([
                'status' => $validated['status'],
                'payment' => $validated['payment'] ?? null,
                'admin_id' => auth()->id()
            ]);

            return back()->with('success', 'Request status updated successfully');
        });
    }

    // Update donor request status
    public function updateDonorStatus(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $donateBlood = DonateBlood::findOrFail($id);

            $validated = $request->validate([
                'status' => 'required|in:Approved,Rejected,Pending',
                'donation_date' => 'nullable|date'
            ]);

            $bloodBank = BloodBank::firstOrCreate(
                ['admin_id' => auth()->id()],
                ['admin_name' => auth()->user()->name]
            );

            if ($validated['status'] == 'Approved' && $donateBlood->status != 'Approved') {
                $currentQuantity = $bloodBank->{$donateBlood->blood_group} ?? 0;
                $bloodBank->{$donateBlood->blood_group} = $currentQuantity + $donateBlood->blood_quantity;
                $bloodBank->save();
            }
            elseif ($donateBlood->status == 'Approved' && $validated['status'] != 'Approved') {
                $currentQuantity = $bloodBank->{$donateBlood->blood_group} ?? 0;
                $bloodBank->{$donateBlood->blood_group} = max(0, $currentQuantity - $donateBlood->blood_quantity);
                $bloodBank->save();
            }

            $donateBlood->update([
                'status' => $validated['status'],
                'donation_date' => $validated['donation_date'] ?? null,
                'admin_id' => auth()->id()
            ]);

            return back()->with('success', 'Request status updated successfully');
        });
    }



    public function history()
    {
        $requests = BloodRequest::with(['user', 'admin'])->get();
        $donations = DonateBlood::with(['user', 'admin'])->get();

        $combinedHistory = collect();

        // Transform requests
        foreach ($requests as $request) {
            $combinedHistory->push([
                'type' => 'request',
                'id' => $request->id,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'blood_group' => $request->blood_group,
                'blood_quantity' => $request->blood_quantity,
                'request_type' => $request->request_type,
                'status' => $request->status,
                'created_at' => $request->created_at,
                'payment' => $request->payment
            ]);
        }

        // Transform donations
        foreach ($donations as $donation) {
            $combinedHistory->push([
                'type' => 'donation',
                'id' => $donation->id,
                'user_name' => $donation->user_name,
                'email' => $donation->email,
                'phone' => $donation->phone,
                'blood_type' => $donation->blood_type,
                'blood_quantity' => $donation->blood_quantity,
                'status' => $donation->status,
                'donation_date' => $donation->donation_date,
                'created_at' => $donation->created_at
            ]);
        }

        // Sort by date (newest first)
        $combinedHistory = $combinedHistory->sortByDesc(function($item) {
            return $item['type'] === 'donation' && isset($item['donation_date'])
                ? $item['donation_date']
                : $item['created_at'];
        });

        return view('admin.request_detail', compact('combinedHistory'));
    }
}
