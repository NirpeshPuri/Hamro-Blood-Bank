<?php
namespace App\Http\Controllers;

use App\Models\BloodBank;
use App\Models\Admin;
use Illuminate\Http\Request;

class BloodBankController extends Controller
{
public function index()
{
$bloodBanks = BloodBank::with('admin')->get();
return view('blood_banks.index', compact('bloodBanks'));
}

public function create()
{
$admins = Admin::all();
return view('blood_banks.create', compact('admins'));
}

public function store(Request $request)
{
$validated = $request->validate([
'admin_id' => 'required|exists:admins,id',
'admin_name' => 'required|string|max:255',
// Initialize all blood types to 0
'A+' => 'integer|min:0',
'A-' => 'integer|min:0',
'B+' => 'integer|min:0',
'B-' => 'integer|min:0',
'AB+' => 'integer|min:0',
'AB-' => 'integer|min:0',
'O+' => 'integer|min:0',
'O-' => 'integer|min:0',
]);

// Set default values if not provided
$validated = array_merge([
'A+' => 0,
'A-' => 0,
'B+' => 0,
'B-' => 0,
'AB+' => 0,
'AB-' => 0,
'O+' => 0,
'O-' => 0,
], $validated);

BloodBank::create($validated);

return redirect()->route('blood-banks.index')
->with('success', 'Blood bank created successfully');
}

public function show(BloodBank $bloodBank)
{
return view('blood_banks.show', compact('bloodBank'));
}

public function edit(BloodBank $bloodBank)
{
$admins = Admin::all();
return view('blood_banks.edit', compact('bloodBank', 'admins'));
}

public function update(Request $request, BloodBank $bloodBank)
{
$validated = $request->validate([
'admin_id' => 'required|exists:admins,id',
'admin_name' => 'required|string|max:255',
'A+' => 'integer|min:0',
'A-' => 'integer|min:0',
'B+' => 'integer|min:0',
'B-' => 'integer|min:0',
'AB+' => 'integer|min:0',
'AB-' => 'integer|min:0',
'O+' => 'integer|min:0',
'O-' => 'integer|min:0',
]);

$bloodBank->update($validated);

return redirect()->route('blood-banks.index')
->with('success', 'Blood bank updated successfully');
}

public function updateStockForm(BloodBank $bloodBank)
{
return view('blood_banks.update_stock', compact('bloodBank'));
}

public function updateStock(Request $request, BloodBank $bloodBank)
{
$validated = $request->validate([
'operation' => 'required|in:add,remove',
'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
'quantity' => 'required|integer|min:1'
]);

$quantity = $validated['operation'] === 'add'
? $validated['quantity']
: -$validated['quantity'];

if (!$bloodBank->updateBloodStock($validated['blood_type'], $quantity)) {
return back()->with('error', 'Failed to update blood stock. Not enough blood to deduct.');
}

return redirect()->route('blood-banks.show', $bloodBank)
->with('success', 'Blood stock updated successfully');
}

public function destroy(BloodBank $bloodBank)
{
$bloodBank->delete();
return redirect()->route('blood-banks.index')
->with('success', 'Blood bank deleted successfully');
}
}
