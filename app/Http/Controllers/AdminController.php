<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard for admins
    public function dashboard()
    {
        return view('admin_dashboard');
    }
}
