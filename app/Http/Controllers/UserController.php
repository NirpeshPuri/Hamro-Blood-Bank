<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Dashboard for receivers
    public function receiverDashboard()
    {
        return view('receiver_dashboard');
    }

    // Dashboard for donors
    public function donorDashboard()
    {
        return view('donor_dashboard');
    }

    public function index()
    {
        $users = User::where('user_type', '!=', 'admin')
            ->select([
                'id',
                'name',
                'age',
                'weight',
                'address',
                'phone',
                'blood_type',
                'user_type',
                'email',
                'created_at'
            ])
            ->latest()
            ->paginate(10);

        return view('admin.user_detail', compact('users'));
    }

    public function destroy(User $user)
    {
        // Extra protection against admin deletion
        if ($user->user_type === 'admin') {
            return redirect()->back()
                ->with('error', 'Admin accounts cannot be deleted through this interface');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
