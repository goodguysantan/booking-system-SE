<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. THE FIX: A "Dev Login" route named 'login'
// When middleware redirects here, we just auto-login a test user.
Route::get('/login', function () {
    // Create a dummy user if one doesn't exist
    $user = User::firstOrCreate(
        ['email' => 'test@iium.edu.my'],
        [
            'name' => 'Test Student',
            'password' => Hash::make('password'),
        ]
    );

    // Log them in
    Auth::login($user);

    // Redirect to the booking page
    return redirect()->route('booking.create');
})->name('login'); // <--- This name fixes the error!


// 2. LOGOUT Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// 3. Protected Booking Routes
Route::middleware('auth')->group(function () {
    
    // Redirect /dashboard to booking
    Route::get('/dashboard', function () {
        return redirect()->route('booking.create');
    })->name('dashboard');

    // Show Booking Form
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');

    // Submit Booking
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // Delete Booking
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
});

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});