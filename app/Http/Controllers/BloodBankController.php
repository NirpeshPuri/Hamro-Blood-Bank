<?php
// app/Http/Controllers/BloodBankController.php

namespace App\Http\Controllers;

use App\Models\BloodBank;
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
        return view('blood_banks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'admin_name' => 'required|string|max:255'
        ]);

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
        return view('blood_banks.edit', compact('bloodBank'));
    }

    public function update(Request $request, BloodBank $bloodBank)
    {
        $validated = $request->validate([
            'admin_name' => 'required|string|max:255'
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
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'quantity' => 'required|integer'
        ]);

        if (!$bloodBank->updateBloodStock($validated['blood_type'], $validated['quantity'])) {
            return back()->with('error', 'Failed to update blood stock. Check if quantity is valid.');
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
