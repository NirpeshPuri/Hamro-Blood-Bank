<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// Homepage and Static Pages
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact_us', function () {
    return view('contact_us');
});

// Contact Form Submission
Route::post('/submit-contact-form', [ContactController::class, 'submitForm']);


use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Admin Routes
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Receiver Routes
Route::middleware(['auth:web'])->group(function () {
    Route::get('/receiver/dashboard', [UserController::class, 'receiverDashboard'])->name('receiver.dashboard');
});

// Donor Routes
Route::middleware(['auth:web'])->group(function () {
    Route::get('/donor/dashboard', [UserController::class, 'donorDashboard'])->name('donor.dashboard');
});

Route::get('/search_blood', function () {
    return view('search_blood');
});


use App\Http\Controllers\BloodSearchController;

// Route for the search page
Route::get('/search-blood', [BloodSearchController::class, 'index'])->name('search.blood')->middleware('auth');

// Route to find nearby admins (AJAX)
Route::post('/find-nearby-admins', [BloodSearchController::class, 'findNearbyAdmins'])->name('find.nearby.admins');

// Route to submit a blood request (AJAX)
Route::post('/submit-request', [BloodSearchController::class, 'submitRequest'])->name('submit.request');

// In routes/web.php
use App\Http\Controllers\EsewaController;
Route::get('/esewa_payment', function () {
    return view('esewa_payment');
});

Route::post('/esewa', [EsewaController::class, 'esewaPay'])->name('esewa');
Route::get('/success', [EsewaController::class, 'esewaPaySuccess'])->name('esewa.success');
Route::get('/failure', [EsewaController::class, 'esewaPayFailed'])->name('esewa.failure');






//Donor
use App\Http\Controllers\DonorController;

Route::get('/donate_blood', [DonorController::class, 'showDonationPage'])->name('donate.blood')->middleware('auth');



        // Handle form submission
        Route::post('/request', [DonorController::class, 'submitDonation'])
            ->name('donate.blood.request');

        // Find nearby blood banks
        Route::post('/find-nearby', [DonorController::class, 'findAdminsBtn'])
            ->name('donate.blood.find-nearby');

