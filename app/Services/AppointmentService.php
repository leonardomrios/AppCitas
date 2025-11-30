<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AppointmentService
{
    /**
     * Check if a doctor is available at a specific time slot.
     *
     * @param int $doctorId
     * @param Carbon $startTime
     * @param Carbon $endTime
     * @return bool
     */
    public function checkAvailability(int $doctorId, Carbon $startTime, Carbon $endTime): bool
    {
        // Check if the time is in the future
        if ($startTime->isPast()) {
            return false;
        }

        // Check weekly availability
        $dayOfWeek = $startTime->dayOfWeek;
        $startTimeStr = $startTime->format('H:i:s');
        $endTimeStr = $endTime->format('H:i:s');

        // Convert Carbon dayOfWeek (0=Sunday, 6=Saturday) to our format (1=Monday, 7=Sunday)
        $dayOfWeekFormatted = $dayOfWeek === 0 ? 7 : $dayOfWeek;
        
        $availability = \App\Models\DoctorAvailability::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeekFormatted)
            ->whereRaw('TIME(start_time) <= ?', [$startTimeStr])
            ->whereRaw('TIME(end_time) >= ?', [$endTimeStr])
            ->first();

        if (!$availability) {
            return false;
        }

        // Check for conflicting appointments (pending or confirmed)
        $conflictingAppointment = Appointment::where('doctor_id', $doctorId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    // Overlapping: start_time is between appointment start and end
                    $q->where('start_time', '<=', $startTime)
                      ->where('end_time', '>', $startTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // Overlapping: end_time is between appointment start and end
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>=', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // Overlapping: appointment completely contains the requested time
                    $q->where('start_time', '>=', $startTime)
                      ->where('end_time', '<=', $endTime);
                });
            })
            ->exists();

        return !$conflictingAppointment;
    }

    /**
     * Calculate the end time based on start time and duration.
     *
     * @param Carbon $startTime
     * @return Carbon
     */
    public function calculateEndTime(Carbon $startTime): Carbon
    {
        $durationMinutes = config('appointment.duration_minutes', 30);
        return $startTime->copy()->addMinutes($durationMinutes);
    }

    /**
     * Get available time slots for a doctor in a given week.
     *
     * @param int $doctorId
     * @param Carbon $weekStart
     * @return Collection
     */
    public function getAvailableSlots(int $doctorId, Carbon $weekStart): Collection
    {
        $weekEnd = $weekStart->copy()->endOfWeek();
        $durationMinutes = config('appointment.duration_minutes', 30);
        $availableSlots = collect();

        $doctor = Doctor::findOrFail($doctorId);

        for ($date = $weekStart->copy(); $date->lte($weekEnd); $date->addDay()) {
            $dayOfWeek = $date->dayOfWeek;
            // Convert Carbon dayOfWeek (0=Sunday, 6=Saturday) to our format (1=Monday, 7=Sunday)
            $dayOfWeekFormatted = $dayOfWeek === 0 ? 7 : $dayOfWeek;
            
            $dayAvailabilities = \App\Models\DoctorAvailability::where('doctor_id', $doctorId)
                ->where('day_of_week', $dayOfWeekFormatted)
                ->get();

            foreach ($dayAvailabilities as $availability) {
                // Get time strings - they come as Carbon instances but we need time strings
                $startTimeStr = is_string($availability->start_time) 
                    ? $availability->start_time 
                    : $availability->start_time->format('H:i:s');
                $endTimeStr = is_string($availability->end_time)
                    ? $availability->end_time
                    : $availability->end_time->format('H:i:s');

                // Parse times
                $dayStart = $date->copy()->setTimeFromTimeString($startTimeStr);
                $dayEnd = $date->copy()->setTimeFromTimeString($endTimeStr);

                // Generate slots
                $currentSlot = $dayStart->copy();
                while ($currentSlot->copy()->addMinutes($durationMinutes)->lte($dayEnd)) {
                    $slotEnd = $currentSlot->copy()->addMinutes($durationMinutes);

                    // Only include slots in the future
                    if ($currentSlot->isFuture()) {
                        // Check if slot is available (no conflicts)
                        if ($this->checkAvailability($doctorId, $currentSlot, $slotEnd)) {
                            $availableSlots->push([
                                'start_time' => $currentSlot->copy(),
                                'end_time' => $slotEnd->copy(),
                                'date' => $currentSlot->format('Y-m-d'),
                                'time' => $currentSlot->format('H:i'),
                            ]);
                        }
                    }

                    $currentSlot->addMinutes($durationMinutes);
                }
            }
        }

        return $availableSlots;
    }
}

