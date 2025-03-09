<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18',
            'weight' => 'required|numeric|min:30',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'blood_type' => 'required|string',
            'user_type' => 'required|in:receiver,donor',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'age' => $request->age,
            'weight' => $request->weight,
            'address' => $request->address,
            'phone' => $request->phone,
            'blood_type' => $request->blood_type,
            'user_type' => $request->user_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
}
