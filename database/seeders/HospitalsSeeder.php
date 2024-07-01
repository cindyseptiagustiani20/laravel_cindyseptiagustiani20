<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hospital::create([
            'name' => 'Hospital 1',
            'address' => '123 Bandung',
            'email' => 'hospital1@gmail.com',
            'phone' => '223-111-2222',
        ]);

        Hospital::create([
            'name' => 'Hospital 2',
            'address' => '456 Bandung',
            'email' => 'hospital2@gmail.com',
            'phone' => '223-111-3333',
        ]);

        Hospital::create([
            'name' => 'Hospital 3',
            'address' => '789 Bandung',
            'email' => 'hospital3@gmail.com',
            'phone' => '223-111-4444',
        ]);
    }
}
