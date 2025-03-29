<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\BloodRequest;
use Illuminate\Support\Facades\Auth;

class BloodSearchController extends Controller
{
    // Show the search page
    public function index()
    {
        return view('search_blood'); // Updated to match the blade file name
    }

    // Find nearby admins using an algorithm
    public function findNearbyAdmins(Request $request)
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

    // Submit request to the nearest admin
    public function submitRequest(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'blood_group' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'blood_quantity' => 'required|integer|min:1',
            'request_type' => 'required|in:Emergency,Rare,Normal',
            'request_form' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'payment_amount' => 'required|numeric',
        ]);

        // Handle file upload
        if ($request->hasFile('request_form')) {
            $image = $request->file('request_form');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/request_forms', $imageName); // Save the image in the storage folder
            $imagePath = 'request_forms/' . $imageName; // Path to store in the database
        }

        // Store the request with user details and image path
        BloodRequest::create([
            'user_id' => Auth::id(), // Store the authenticated user's ID
            'admin_id' => $request->admin_id,
            'blood_group' => $request->blood_group,
            'blood_quantity' => $request->blood_quantity,
            'request_type' => $request->request_type,
            'request_form' => $imagePath,
            'payment' => $request->payment_amount, // Store payment amount
        ]);

        return response()->json(['message' => 'Request submitted successfully!']);
    }
}
