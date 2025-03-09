<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\ContactController;

// Add this route for the contact form submission
Route::post('/submit-contact-form', [ContactController::class, 'submitForm']);
