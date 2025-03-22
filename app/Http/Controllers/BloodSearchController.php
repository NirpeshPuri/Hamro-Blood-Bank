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

// Find nearby admins
public function findNearbyAdmins(Request $request)
{
$userLat = $request->input('latitude');
$userLng = $request->input('longitude');

// Fetch admins and calculate distance
$admins = Admin::selectRaw('*, ( 6371 * acos( cos( radians(?) ) *
cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) +
sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance', [$userLat, $userLng, $userLat])
->orderBy('distance')
->get();

return response()->json($admins);
}

// Submit request to the nearest admin
public function submitRequest(Request $request)
{
$request->validate([
'admin_id' => 'required|exists:admins,id',
'request_type' => 'required|in:Emergency,Rare,Normal',
'request_form' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
'request_type' => $request->request_type,
'request_form' => $imagePath,
'status' => 'Pending',
'payment' => 'Unpaid',
]);

return response()->json(['message' => 'Request submitted successfully!']);
}
}
