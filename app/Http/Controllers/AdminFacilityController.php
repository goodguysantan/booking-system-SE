<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Bookings;

class AdminFacilityController extends Controller
{
    public function index(){
        $allBookings = Bookings::with('user', 'facility')->latest()->get();
        $facilities = Facility::all();
        $unavailableFacilities = Facility::where('status', 'maintenance')->get();
        return view('admin', compact('allBookings', 'facilities', 'unavailableFacilities'));
    }

    public function updateStatus(Request $request){
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'status' => 'required|in:available,maintenance'
        ]);

        $facility = Facility::find($request->facility_id);
        $facility->update(['status' => $request->status]);
        

        return back()->with('success', 'Facility status updated successfully!');
    }
}
