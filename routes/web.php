<?php

use App\Http\Controllers\ProfileUpdateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// Homepage and Static Pages
Route::get('/', function () {
    return view('login');
});

Route::get('/home', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    switch (auth()->user()->user_type) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'donor':
            return redirect()->route('donor.dashboard');
        case 'receiver':
            return redirect()->route('receiver.dashboard');
        default:
            return redirect()->route('login')->with('error', 'Unknown user type');
    }
})->middleware('auth');

Route::get('/about', function () {
    return view('about'); // Same content for all
})->name('about');
Route::get('/donor_about', function () {
    return view('donor_about'); // Same content for all
})->name('donor_about');
// Display contact form
Route::get('/contact_us', function () {
    return view('contact_us'); // Same content for all
})->name('contact_us');
Route::get('/donor_contact_us', function () {
    return view('donor_contact_us'); // Same content for all
})->name('donor_contact_us');
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

    // Donor Requests
    Route::get('/admin/donor-requests', [AdminController::class, 'donorRequests'])->name('admin.donor.requests');

    // Update Status Routes
    Route::post('/admin/receiver-requests/{id}/update-status', [AdminController::class, 'updateReceiverStatus'])
        ->name('admin.receiver.update-status');

    Route::post('/admin/donor-requests/{id}/update-status', [AdminController::class, 'updateDonorStatus'])
        ->name('admin.donor.update-status');


    Route::get('/', [UserController::class, 'index'])->name('admin.user_detail');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

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
Route::post('/submit-request', [BloodSearchController::class, 'submitRequest'])->name('submit.blood.request');


use App\Http\Controllers\EsewaController;
Route::get('/esewa_payment', function () {
    return view('esewa_payment');
});

Route::post('/esewa', [EsewaController::class, 'esewaPay'])->name('esewa');
Route::get('/success', [EsewaController::class, 'esewaPaySuccess'])->name('esewa.success');
Route::get('/failure', [EsewaController::class, 'esewaPayFailed'])->name('esewa.failure');


use App\Http\Controllers\ReceiverStatusController;

Route::middleware(['auth'])->group(function () {
    // Receiver status routes
    Route::get('/receiver/status', [ReceiverStatusController::class, 'index'])
        ->name('receiver.status');
    Route::get('/receiver/request/{id}/edit', [ReceiverStatusController::class, 'edit'])
        ->name('receiver.request.edit');
    Route::put('/receiver/request/{id}', [ReceiverStatusController::class, 'update'])
        ->name('receiver.request.update');
    Route::delete('/receiver/request/{id}', [ReceiverStatusController::class, 'destroy'])
        ->name('receiver.request.destroy');

    Route::get('/receiver_update_profile', [ProfileUpdateController::class, 'showUpdateForm1'])->name('receiver.profile.update');
    Route::post('/receiver_update_profile', [ProfileUpdateController::class, 'update']);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::get('/blood-banks/{adminId}/stock', function($adminId) {
        $bloodBank = App\Models\BloodBank::where('admin_id', $adminId)->firstOrFail();

        return response()->json([
            'A+' => $bloodBank->{'A+'} ?? 0,
            'A-' => $bloodBank->{'A-'} ?? 0,
            'B+' => $bloodBank->{'B+'} ?? 0,
            'B-' => $bloodBank->{'B-'} ?? 0,
            'AB+' => $bloodBank->{'AB+'} ?? 0,
            'AB-' => $bloodBank->{'AB-'} ?? 0,
            'O+' => $bloodBank->{'O+'} ?? 0,
            'O-' => $bloodBank->{'O-'} ?? 0
        ]);
    });
});





//Donor

use App\Http\Controllers\DonorController;
Route::get('/donor_status', [DonorController::class, 'status'])->name('donate.blood')->middleware('auth');
Route::get('/edit_donation', [DonorController::class, 'edit'])->name('edit.donate.blood')->middleware('auth');
Route::middleware(['auth'])->prefix('donor')->group(function () {
    // Donation request
    Route::get('/donate', [DonorController::class, 'showDonationPage'])->name('donate.blood');
    Route::post('/find-nearby', [DonorController::class, 'findAdminsBtn'])->name('donate.blood.find-nearby');
    Route::post('/request', [DonorController::class, 'submitDonation'])->name('donate.blood.request');
    Route::get('/check-eligibility', [DonorController::class, 'checkEligibility'])->name('donate.blood.check-eligibility');
    // Donation status
    Route::get('/donor_status', [DonorController::class, 'status'])->name('donor.status');
    Route::get('/edit_donation/{id}/edit', [DonorController::class, 'edit'])->name('donor.donation.edit');
    Route::put('/donation/{id}', [DonorController::class, 'update'])->name('donor.donation.update');
    Route::delete('/donor/donations/{donation}', [DonorController::class, 'destroy'])
        ->name('donor.donations.destroy');

    Route::get('/donor_update_profile', [ProfileUpdateController::class, 'showUpdateForm'])->name('profile.update');
    Route::post('/donor_update_profile', [ProfileUpdateController::class, 'update']);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});



use App\Http\Controllers\BloodBankController;

Route::prefix('blood-banks')->middleware('auth:admin')->group(function () {
    Route::get('/', [BloodBankController::class, 'show'])->name('blood-banks.show');
    Route::get('/update-stock', [BloodBankController::class, 'updateStockForm'])->name('blood-banks.update-form');
    Route::post('/update-stock', [BloodBankController::class, 'updateStock'])->name('blood-banks.update');
});






