<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Badminton Courts (Courts 1-4)
        for ($i = 1; $i <= 4; $i++) {
            Facility::create([
                'name' => 'Badminton Court',
                'court_number' => $i,
                'status' => 'available'
            ]);
        }

        // Futsal Courts (Courts 1-2)
        for ($i = 1; $i <= 2; $i++) {
            Facility::create([
                'name' => 'Futsal Court',
                'court_number' => $i,
                'status' => 'available'
            ]);
        }

        // Tennis Court (Court 1)
        Facility::create([
            'name' => 'Tennis Court',
            'court_number' => 1,
            'status' => 'available'
        ]);
    }
}
