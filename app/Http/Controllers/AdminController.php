<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\DonateBlood;
use App\Models\BloodBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $requests = BloodRequest::with(['user', 'admin'])
            ->where('status', 'pending')
            ->orderByRaw("
            CASE
                WHEN request_type = 'Emergency' THEN 0
                WHEN request_type = 'Rare' THEN 1
                ELSE 2
            END
        ")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_dashboard', ['requests' => $requests]);
    }

    public function donorRequests()
    {
        $requests = DonateBlood::with(['user', 'admin'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.donor_request', compact('requests'));
    }

    public function updateReceiverStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $bloodRequest = BloodRequest::findOrFail($id);
            $action = $request->input('action');

            if (!in_array($action, ['approve', 'reject'])) {
                throw new \Exception('Invalid action specified');
            }

            $status = $action === 'approve' ? 'approved' : 'rejected';
            $bloodBank = BloodBank::currentAdminBank();

            if ($status === 'approved') {
                $bloodBank->updateStock(
                    $bloodRequest->blood_group,
                    -$bloodRequest->blood_quantity
                );
            }

            $bloodRequest->status = $status;
            $bloodRequest->admin_id = auth()->id();
            $bloodRequest->save();

            DB::commit();
            return back()->with('success', "Request {$status} successfully");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateDonorStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $donateBlood = DonateBlood::findOrFail($id);
            $action = $request->input('action');

            if (!in_array($action, ['approve', 'reject'])) {
                throw new \Exception('Invalid action specified');
            }

            $status = $action === 'approve' ? 'approved' : 'rejected';
            $bloodBank = BloodBank::currentAdminBank();

            if ($status === 'approved') {
                $bloodBank->updateStock(
                    $donateBlood->blood_type,
                    $donateBlood->blood_quantity
                );
            }

            $donateBlood->status = $status;

            $donateBlood->admin_id = auth()->id();
            $donateBlood->save();

            DB::commit();
            return back()->with('success', "Donor request {$status} successfully");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function showBloodInventory()
    {
        try {
            $bloodBank = BloodBank::currentAdminBank();
            return view('admin.blood_inventory', compact('bloodBank'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
