<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. Carlos Ramírez',
                'slug' => 'dr-carlos-ramirez',
                'email' => 'carlos.ramirez@clinicagastro.com',
                'phone' => '+52 55 1234 5678',
                'specialty' => 'Gastroenterología',
                'bio' => 'Especialista en gastroenterología con más de 15 años de experiencia. Especializado en enfermedades digestivas y endoscopías.',
            ],
            [
                'name' => 'Dra. María González',
                'slug' => 'dra-maria-gonzalez',
                'email' => 'maria.gonzalez@clinicagastro.com',
                'phone' => '+52 55 2345 6789',
                'specialty' => 'Gastroenterología',
                'bio' => 'Médica gastroenteróloga certificada. Experta en hepatología y enfermedades del hígado.',
            ],
            [
                'name' => 'Dr. Luis Martínez',
                'slug' => 'dr-luis-martinez',
                'email' => 'luis.martinez@clinicagastro.com',
                'phone' => '+52 55 3456 7890',
                'specialty' => 'Gastroenterología',
                'bio' => 'Especialista en endoscopia digestiva y tratamiento de enfermedades inflamatorias intestinales.',
            ],
        ];

        foreach ($doctors as $doctorData) {
            Doctor::create($doctorData);
        }
    }
}
