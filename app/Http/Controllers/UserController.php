<?php

namespace App\Http\Controllers;

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
}
