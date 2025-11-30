<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Appointment Duration
    |--------------------------------------------------------------------------
    |
    | Default duration of appointments in minutes. This value can be overridden
    | by setting APPOINTMENT_DURATION_MINUTES in your .env file.
    |
    */

    'duration_minutes' => env('APPOINTMENT_DURATION_MINUTES', 30),

    /*
    |--------------------------------------------------------------------------
    | Appointment Statuses
    |--------------------------------------------------------------------------
    |
    | Available statuses for appointments and their allowed transitions.
    |
    */

    'statuses' => [
        'pending' => 'Pendiente',
        'confirmed' => 'Confirmada',
        'completed' => 'Completada',
        'rejected' => 'Rechazada',
    ],

    /*
    |--------------------------------------------------------------------------
    | Status Transitions
    |--------------------------------------------------------------------------
    |
    | Define allowed status transitions for appointments.
    |
    */

    'status_transitions' => [
        'pending' => ['confirmed', 'rejected'],
        'confirmed' => ['completed'],
        'rejected' => [],
        'completed' => [],
    ],
];

