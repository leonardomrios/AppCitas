<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorAvailability;
use Illuminate\Database\Seeder;

class DoctorAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            // Lunes a Viernes: 9:00 AM - 1:00 PM y 3:00 PM - 7:00 PM
            // Lunes (1)
            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 1, // Monday
                'start_time' => '09:00:00',
                'end_time' => '13:00:00',
            ]);

            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 1, // Monday
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
            ]);

            // Martes (2)
            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 2, // Tuesday
                'start_time' => '09:00:00',
                'end_time' => '13:00:00',
            ]);

            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 2, // Tuesday
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
            ]);

            // Miércoles (3)
            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 3, // Wednesday
                'start_time' => '09:00:00',
                'end_time' => '13:00:00',
            ]);

            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 3, // Wednesday
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
            ]);

            // Jueves (4)
            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 4, // Thursday
                'start_time' => '09:00:00',
                'end_time' => '13:00:00',
            ]);

            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 4, // Thursday
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
            ]);

            // Viernes (5)
            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 5, // Friday
                'start_time' => '09:00:00',
                'end_time' => '13:00:00',
            ]);

            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 5, // Friday
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
            ]);
        }
    }
}

