<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\DoctorAvailability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorAvailability>
 */
class DoctorAvailabilityFactory extends Factory
{
    protected $model = DoctorAvailability::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::factory(),
            'day_of_week' => fake()->numberBetween(1, 7), // 1 = Monday, 7 = Sunday
            'start_time' => fake()->time('08:00', '09:00'),
            'end_time' => fake()->time('17:00', '18:00'),
        ];
    }
}

