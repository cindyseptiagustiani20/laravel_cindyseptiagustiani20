<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create([
            'name' => 'Patient 1',
            'address' => '123 Bandung',
            'phone' => '223-111-2222',
            'hospital_id' => 1,
        ]);

        Patient::create([
            'name' => 'Patient 2',
            'address' => '456 Bandung',
            'phone' => '223-111-3333',
            'hospital_id' => 1,
        ]);

        Patient::create([
            'name' => 'Patient 3',
            'address' => '789 Bandung',
            'phone' => '223-111-4444',
            'hospital_id' => 3,
        ]);

        Patient::create([
            'name' => 'Patient 4',
            'address' => '101 Bandung',
            'phone' => '223-111-5555',
            'hospital_id' => 3,
        ]);

        Patient::create([
            'name' => 'Patient 5',
            'address' => '112 Bandung',
            'phone' => '223-111-6666',
            'hospital_id' => 2,
        ]);
    }
}
