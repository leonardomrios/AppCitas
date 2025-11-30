<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Appointment extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'slug',
        'doctor_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'reason',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the source column for slug generation.
     */
    protected function getSlugSourceColumn(): string
    {
        return 'patient_name';
    }

    /**
     * Get the source value for slug generation (using unique combination).
     */
    protected function getSlugSource(): string
    {
        $patientName = $this->patient_name ?? 'appointment';
        $dateTime = $this->start_time 
            ? $this->start_time->format('Y-m-d-H-i') 
            : now()->format('Y-m-d-H-i-s');
        return $patientName . '-' . $dateTime;
    }

    /**
     * Get the doctor that owns the appointment.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Scope a query to only include pending appointments.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed appointments.
     */
    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include completed appointments.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include rejected appointments.
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope a query to filter appointments by doctor.
     */
    public function scopeForDoctor(Builder $query, int $doctorId): Builder
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Check if the appointment can be accepted.
     */
    public function canBeAccepted(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the appointment can be rejected.
     */
    public function canBeRejected(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the appointment can be completed.
     */
    public function canBeCompleted(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if the appointment can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Get the duration of the appointment in minutes.
     */
    public function duration(): int
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }
}
