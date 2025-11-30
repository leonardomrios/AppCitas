<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('+1 day', '+30 days');
        $durationMinutes = config('appointment.duration_minutes', 30);
        $endTime = (clone $startTime)->modify("+{$durationMinutes} minutes");

        return [
            'doctor_id' => Doctor::inRandomOrder()->first()?->id ?? Doctor::factory(),
            'patient_name' => fake()->name(),
            'patient_email' => fake()->safeEmail(),
            'patient_phone' => fake()->phoneNumber(),
            'reason' => fake()->sentence(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed', 'rejected']),
        ];
    }

    /**
     * Indicate that the appointment is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the appointment is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate that the appointment is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    /**
     * Indicate that the appointment is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }
}
