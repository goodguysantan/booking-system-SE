<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminFacilityController extends Controller
{
    public function updateStatus(Request $request, Facility $facility){
        $facility->update(['status' => $request->status]);
        return back()->with('success', 'Facility status updated');
    }
}
