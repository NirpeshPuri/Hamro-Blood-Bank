<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\DonateBlood;
use App\Models\BloodBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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


    public function showProfileUpdateForm()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.admin_update_profile', compact('admin'));
    }

    /**
     * Handle admin profile update
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z ]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($admin->id),
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'phone' => [
                'required',
                'string',
                'digits:10',
                'regex:/^[0-9]{10}$/'
            ],
            'address' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s,.-]+$/'
            ],
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90'
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180'
            ],
            'password' => [
                'nullable',
                'confirmed',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/'
            ]
        ], [
            'name.regex' => 'Name should contain only alphabets and spaces',
            'email.regex' => 'Please enter a valid email address',
            'phone.regex' => 'Phone number must be exactly 10 digits',
            'phone.digits' => 'Phone number must be exactly 10 digits',
            'address.regex' => 'Address contains invalid characters',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character'
        ]);

        try {
            // Only update password if it was provided
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = bcrypt($validated['password']);
            }

            $admin->update($validated);

            return redirect()->route('admin.profile')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update profile. Please try again.');
        }
    }
}
