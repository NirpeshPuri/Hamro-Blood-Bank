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

