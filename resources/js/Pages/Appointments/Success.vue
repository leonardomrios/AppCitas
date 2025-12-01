<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    appointment: Object,
});
</script>

<template>
    <GuestLayout title="Cita Confirmada">
        <Head title="Cita Confirmada" />

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 text-center">
                        <!-- Success Icon -->
                        <div class="flex justify-center mb-6">
                            <div class="rounded-full bg-green-100 p-6">
                                <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Success Message -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            ¡Cita Reservada con Éxito!
                        </h1>
                        
                        <p class="text-lg text-gray-600 mb-6">
                            En breve recibirás un correo de confirmación con los detalles de tu cita.
                        </p>

                        <!-- Appointment Details -->
                        <div v-if="appointment" class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Detalles de la Cita</h2>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Paciente:</span>
                                    <span class="font-medium text-gray-900">{{ appointment.patient_name }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium text-gray-900">{{ appointment.patient_email }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Teléfono:</span>
                                    <span class="font-medium text-gray-900">{{ appointment.patient_phone }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Médico:</span>
                                    <span class="font-medium text-gray-900">{{ appointment.doctor?.name }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Especialidad:</span>
                                    <span class="font-medium text-gray-900">{{ appointment.doctor?.specialty }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Fecha y Hora:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ new Date(appointment.start_time).toLocaleString('es-ES', { 
                                            weekday: 'long', 
                                            year: 'numeric', 
                                            month: 'long', 
                                            day: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        }) }}
                                    </span>
                                </div>
                                
                                <div class="pt-3 border-t border-gray-200">
                                    <span class="text-gray-600 block mb-2">Motivo:</span>
                                    <p class="text-gray-900">{{ appointment.reason }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Information Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-left">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">Importante:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Revisa tu correo electrónico para recordar los detalles de la cita</li>
                                        <li>Si necesitas cancelar, comunícate a la linea 123-456-7890</li>
                                        <li>Llega 10 minutos antes de tu cita</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link :href="route('welcome')">
                                <PrimaryButton class="w-full sm:w-auto">
                                    Volver al Inicio
                                </PrimaryButton>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
