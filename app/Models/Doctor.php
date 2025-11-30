<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'email',
        'phone',
        'specialty',
        'bio',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the doctor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appointments for the doctor.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the availabilities for the doctor.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(DoctorAvailability::class);
    }

    /**
     * Check if the doctor is available at a specific time.
     */
    public function isAvailable(\Carbon\Carbon $dateTime): bool
    {
        // Convert Carbon dayOfWeek (0=Sunday, 6=Saturday) to our format (1=Monday, 7=Sunday)
        $carbonDayOfWeek = $dateTime->dayOfWeek;
        $dayOfWeek = $carbonDayOfWeek === 0 ? 7 : $carbonDayOfWeek;
        $time = $dateTime->format('H:i:s');

        // Check availability - convert time to string for comparison
        $timeStr = $time->format('H:i:s');
        $availability = $this->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->whereRaw('TIME(start_time) <= ?', [$timeStr])
            ->whereRaw('TIME(end_time) >= ?', [$timeStr])
            ->first();

        if (!$availability) {
            return false;
        }

        // Check for conflicting appointments
        $conflictingAppointment = $this->appointments()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($dateTime) {
                $query->where(function ($q) use ($dateTime) {
                    $q->where('start_time', '<=', $dateTime)
                      ->where('end_time', '>', $dateTime);
                })->orWhere(function ($q) use ($dateTime) {
                    $q->where('start_time', '<', $dateTime->copy()->addMinutes(config('appointment.duration_minutes')))
                      ->where('end_time', '>=', $dateTime);
                });
            })
            ->first();

        return $conflictingAppointment === null;
    }

    /**
     * Get availability for a specific week.
     */
    public function getAvailabilityForWeek(\Carbon\Carbon $weekStart): array
    {
        $weekEnd = $weekStart->copy()->endOfWeek();
        $availabilities = [];

        for ($date = $weekStart->copy(); $date->lte($weekEnd); $date->addDay()) {
            // Convert Carbon dayOfWeek (0=Sunday, 6=Saturday) to our format (1=Monday, 7=Sunday)
            $carbonDayOfWeek = $date->dayOfWeek;
            $dayOfWeek = $carbonDayOfWeek === 0 ? 7 : $carbonDayOfWeek;
            
            $dayAvailability = $this->availabilities()
                ->where('day_of_week', $dayOfWeek)
                ->get();

            if ($dayAvailability->isNotEmpty()) {
                $availabilities[$date->format('Y-m-d')] = $dayAvailability;
            }
        }

        return $availabilities;
    }
}
