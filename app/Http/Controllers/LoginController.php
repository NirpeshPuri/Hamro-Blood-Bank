<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'user_type' => 'required|in:receiver,donor,admin',
        ]);

        // Attempt to log in based on user type
        if ($request->user_type === 'admin') {
            // Log in as admin
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('admin.dashboard');
            }
        } else {
            // Log in as user (receiver or donor)
            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::guard('web')->user();
                if ($user->user_type === $request->user_type) {
                    return redirect()->route($request->user_type . '.dashboard');
                }
            }
        }

        // Redirect back with error message
        return redirect()->back()->with('error', 'Invalid email, password, or user type.');
    }

    public function logout(Request $request)
    {
        // Log out from the appropriate guard
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
