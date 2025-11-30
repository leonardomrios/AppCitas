<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@clinicagastro.com',
        ]);

        // Seed doctors and their availability
        $this->call([
            DoctorSeeder::class,
            DoctorAvailabilitySeeder::class,
        ]);
    }
}
