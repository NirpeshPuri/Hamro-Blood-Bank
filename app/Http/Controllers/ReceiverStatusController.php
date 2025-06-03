<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ReceiverStatusController extends Controller
{
    public function index()
    {
        $requests = BloodRequest::where('user_id', Auth::id())
            ->with('admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('receiver_status', compact('requests'));
    }

    public function edit($id)
    {
        $request = BloodRequest::where('user_id', Auth::id())->findOrFail($id);

        if (!$request->canEdit()) {
            return redirect()->route('receiver.status')->with('error', 'Cannot edit this request.');
        }

        $adminId = $request->admin_id;

        // Fetch stock data from BloodBank model
        $bloodBank = \App\Models\BloodBank::where('admin_id', $adminId)->first();
        $stock = [
            'A+' => $bloodBank->{'A+'} ?? 0,
            'A-' => $bloodBank->{'A-'} ?? 0,
            'B+' => $bloodBank->{'B+'} ?? 0,
            'B-' => $bloodBank->{'B-'} ?? 0,
            'AB+' => $bloodBank->{'AB+'} ?? 0,
            'AB-' => $bloodBank->{'AB-'} ?? 0,
            'O+' => $bloodBank->{'O+'} ?? 0,
            'O-' => $bloodBank->{'O-'} ?? 0,
        ];

        return view('edit_request', [
            'request' => $request,
            'currentFileUrl' => $request->file_url,
            'adminId' => $adminId,
            'stock' => $stock,
        ]);
    }


    public function update(Request $request, $id)
    {

        $bloodRequest = BloodRequest::where('user_id', Auth::id())->findOrFail($id);

        if (!$bloodRequest->canEdit()) {
            return redirect()->route('receiver.status')->with('error', 'Cannot update this request.');
        }

        $validated = $request->validate([
            'blood_group' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'blood_quantity' => 'required|integer|min:1',
            'request_type' => 'required|in:Emergency,Rare,Normal',
            'request_form' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'payment' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('request_form')) {
            // Delete old file if exists in public directory
            if ($bloodRequest->request_form && file_exists(public_path($bloodRequest->request_form))) {
                File::delete(public_path($bloodRequest->request_form));
            }

            // Store new file in public/assets/request_forms
            $imageName = time().'.'.$request->file('request_form')->getClientOriginalExtension();
            $request->file('request_form')->move(public_path('assets/request_forms'), $imageName);
            $validated['request_form'] = 'assets/request_forms/'.$imageName;
        }

        $bloodRequest->update($validated);

        return redirect()->route('receiver.status')->with('success', 'Request updated successfully.');
    }

    public function destroy($id)
    {
        $bloodRequest = BloodRequest::where('user_id', Auth::id())->findOrFail($id);

        if (!$bloodRequest->canEdit()) {
            return redirect()->route('receiver.status')->with('error', 'Cannot delete this request.');
        }

        // Delete associated file from public directory
        if ($bloodRequest->request_form && file_exists(public_path($bloodRequest->request_form))) {
            File::delete(public_path($bloodRequest->request_form));
        }

        $bloodRequest->delete();

        return redirect()->route('receiver.status')->with('success', 'Request deleted successfully.');
    }
}
