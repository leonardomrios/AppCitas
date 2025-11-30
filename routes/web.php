<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/doctors/{doctor:slug}', [DoctorController::class, 'show']);
Route::get('/appointments/new', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

// Protected routes (admin)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // Doctors resource routes
    Route::resource('doctors', DoctorController::class)->except(['show']);

    // Appointments resource routes
    Route::resource('appointments', AppointmentController::class);
    Route::post('/appointments/{appointment:slug}/accept', [AppointmentController::class, 'accept'])->name('appointments.accept');
    Route::post('/appointments/{appointment:slug}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');
    Route::post('/appointments/{appointment:slug}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::post('/appointments/{appointment:slug}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

Route::get('/home', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

