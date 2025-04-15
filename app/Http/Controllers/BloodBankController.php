<?php
namespace App\Http\Controllers;

use App\Models\BloodBank;
use Illuminate\Http\Request;

class BloodBankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function show()
    {
        $bloodBank = BloodBank::currentAdminBank();
        return view('blood_banks.show', compact('bloodBank'));
    }

    public function updateStockForm()
    {
        $bloodBank = BloodBank::currentAdminBank();
        return view('blood_banks.update_stock', compact('bloodBank'));
    }

    public function updateStock(Request $request)
    {
        $validated = $request->validate([
            'operation' => 'required|in:add,remove',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'quantity' => 'required|integer|min:1'
        ]);

        $bloodBank = BloodBank::currentAdminBank();
        $quantity = $validated['operation'] === 'add'
            ? $validated['quantity']
            : -$validated['quantity'];

        if (!$bloodBank->updateStock($validated['blood_type'], $quantity)) {
            return back()->with('error', 'Not enough blood to deduct.');
        }

        return redirect()->route('blood-banks.show')
            ->with('success', 'Blood stock updated successfully');
    }


}
