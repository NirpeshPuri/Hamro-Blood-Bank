<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BloodSearchController extends Controller
{
    public function index()
    {
        return view('search_blood');
    }

    public function findNearbyAdmins(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $admins = Admin::select(['id', 'name', 'latitude', 'longitude'])->get();

        $adminsWithDistance = $admins->map(function ($admin) use ($request) {
            $admin->distance = $this->calculateDistance( // Calculate distance for each
                $request->latitude,
                $request->longitude,
                $admin->latitude,
                $admin->longitude
            );
            return $admin;
        });

        return response()->json($adminsWithDistance->sortBy('distance')->values());
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

    public function submitRequest(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'blood_group' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'blood_quantity' => 'required|integer|min:1|max:2',
            'request_type' => 'required|in:Emergency,Rare,Normal',
            'request_form' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'payment' => 'required|numeric|min:0|max:1500',
        ]);

        $user = Auth::user();
        //$imagePath = $request->file('request_form')->store('request_forms', 'public');

        $imageName = time().'.'.$request->file('request_form')->getClientOriginalExtension();
        $request->file('request_form')->move(public_path('assets/request_forms'), $imageName);
        $imagePath = 'assets/request_forms/'.$imageName;

        $bloodRequest = BloodRequest::create([
            'user_id' => $user->id,
            'admin_id' => $request->admin_id,
            'user_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'blood_group' => $request->blood_group,
            'blood_quantity' => $request->blood_quantity,
            'request_type' => $request->request_type,
            'request_form' => $imagePath,
            'payment' => $request->payment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Blood request submitted successfully!',
            'request_id' => $bloodRequest->id,
            'payment' => $bloodRequest->payment
        ]);
    }

    private function storeRequestForm($file)
    {
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/request_forms', $imageName);
        return 'request_forms/' . $imageName;
    }
}
