<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'court_number', 'status'];

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
