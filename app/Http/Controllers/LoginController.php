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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'user_type' => 'required|in:receiver,donor,admin',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if ($request->user_type === 'admin') {
            if (Auth::guard('admin')->attempt($credentials, $remember)) {
                return redirect()->route('admin.dashboard');
            }
        } else {
            if (Auth::guard('web')->attempt($credentials, $remember)) {
                $user = Auth::guard('web')->user();
                if ($user->user_type === $request->user_type) {
                    return redirect()->route($request->user_type . '.dashboard');
                }
                Auth::guard('web')->logout(); // Log out if user type doesn't match
            }
        }

        return redirect()->route('login')
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Invalid credentials or user type.',
            ]);
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
