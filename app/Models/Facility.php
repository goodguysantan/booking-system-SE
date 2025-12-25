<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['name', 'court_number', 'status'];

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
