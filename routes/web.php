<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminFacilityController;

// --- PUBLIC ROUTES (Login & Register) ---

// 1. The Main Login Page
Route::get('/', function () {
    // MANUAL CHECK: If already logged in...
    if (Auth::check()) {
        // send Admin to Dashboard
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        // send Student to Booking
        return redirect()->route('booking.create');
    }
    
    // If NOT logged in, show the login form
    return view('login');
})->name('login');

// 2. The Register Page
Route::get('/register', function () {
    // Same manual check here
    if (Auth::check()) {
        return Auth::user()->is_admin ? redirect()->route('admin.dashboard') : redirect()->route('booking.create');
    }
    return view('register');
})->name('register');

// 3. Handle Login Submission
Route::post('/login', function (Request $request) {
    // login logic
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Redirect based on role
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('booking.create');
    }

    return back()->withErrors(['email' => 'Invalid email or password.']);
})->name('login.submit');

// 4. Handle Register Submission
Route::post('/register', function (Request $request) {
    // register logic
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'is_admin' => 0 
    ]);

    Auth::login($user);
    return redirect()->route('booking.create');
})->name('register.submit');

// --- AUTH ROUTES (Must be Logged In) ---
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');

    // User Booking Routes
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');

    // Admin Dashboard Placeholder
    Route::get('/admin/dashboard', [AdminFacilityController::class, 'index'])->name('admin.dashboard');
         
    Route::post('/admin/status', [AdminFacilityController::class, 'updateStatus'])->name('admin.updateStatus'); 
});