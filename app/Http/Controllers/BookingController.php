<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Facility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(){
        $facilities = Facility::where('status', 'available')->get();
        $myBookings = Auth::user()->bookings()->with('facility')->get();
        return view('create', compact('facilities', 'myBookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'duration' => 'required|integer|min:1|max:3'
        ]);

        $exists = Bookings::where('facility_id', $request->facility_id)
            ->where('date', $request->date)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($exists){
            return back()->withErrors(['msg'=>'Time slot is already occupied']);
        }

        Bookings::create([
            'user_id' => Auth::id(),
            'facility_id' => $request->facility_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'duration' => $request->duration
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking created successfully.');
    }

    public function destroy(Bookings $booking){
        if ($booking->user_id == Auth::id()) {
            $booking->delete();
            return back()->with('success', 'Booking cancelled.');
        }
        return back()->with('error', 'Unauthorized');
    }
}