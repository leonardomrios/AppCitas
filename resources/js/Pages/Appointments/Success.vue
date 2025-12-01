<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';

const props = defineProps({
    appointment: Object,
});

const showConfetti = ref(false);

onMounted(() => {
    showConfetti.value = true;
});
</script>

<template>
    <GuestLayout title="Cita Confirmada">
        <Head title="Cita Confirmada" />

        <div class="py-12 relative">
            <!-- Animated Background -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-10 left-10 w-20 h-20 bg-health-200 rounded-full opacity-20 animate-pulse-slow"></div>
                <div class="absolute top-40 right-20 w-32 h-32 bg-medical-200 rounded-full opacity-20 animate-pulse-slow" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-health-300 rounded-full opacity-20 animate-pulse-slow" style="animation-delay: 2s;"></div>
            </div>

            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 relative z-10">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-scale-in">
                    <div class="p-8 md:p-12 text-center">
                        <!-- Success Icon with Animation -->
                        <div class="flex justify-center mb-8">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-health-400 to-health-600 rounded-full blur-xl opacity-50 animate-pulse"></div>
                                <div class="relative rounded-full bg-gradient-to-br from-health-400 to-health-600 p-6 shadow-2xl animate-scale-in">
                                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Success Message -->
                        <div class="animate-fade-in" style="animation-delay: 0.2s;">
                            <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-medical-600 to-health-600 bg-clip-text text-transparent mb-4">
                                ¡Cita Reservada con Éxito!
                            </h1>
                            
                            <p class="text-lg md:text-xl text-gray-600 mb-8">
                                Tu cita ha sido confirmada. En breve recibirás un correo con todos los detalles.
                            </p>
                        </div>

                        <!-- Appointment Details Card -->
                        <div v-if="appointment" class="bg-gradient-to-br from-medical-50 via-white to-health-50 rounded-2xl p-8 mb-8 text-left animate-slide-up" style="animation-delay: 0.3s;">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center justify-center">
                                <svg class="w-7 h-7 mr-3 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Detalles de tu Cita
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-medical-100 rounded-lg p-2">
                                            <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 mb-1">Paciente</p>
                                            <p class="font-bold text-gray-900">{{ appointment.patient_name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-health-100 rounded-lg p-2">
                                            <svg class="w-5 h-5 text-health-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 mb-1">Email</p>
                                            <p class="font-medium text-gray-900 text-sm break-all">{{ appointment.patient_email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-medical-100 rounded-lg p-2">
                                            <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 mb-1">Teléfono</p>
                                            <p class="font-medium text-gray-900">{{ appointment.patient_phone }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-health-100 rounded-lg p-2">
                                            <svg class="w-5 h-5 text-health-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 mb-1">Médico</p>
                                            <p class="font-bold text-gray-900">{{ appointment.doctor?.name }}</p>
                                            <p class="text-xs text-medical-600 mt-0.5">{{ appointment.doctor?.specialty }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Date & Time - Full Width -->
                            <div class="bg-gradient-to-r from-medical-500 to-health-600 rounded-xl p-6 mt-4 text-white">
                                <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-8">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-medical-100 text-sm">Fecha</p>
                                            <p class="font-bold text-lg">{{ new Date(appointment.start_time).toLocaleDateString('es-ES', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-medical-100 text-sm">Hora</p>
                                            <p class="font-bold text-lg">{{ new Date(appointment.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reason -->
                            <div class="bg-white rounded-xl p-4 shadow-sm mt-4">
                                <p class="text-xs text-gray-500 mb-2">Motivo de la Consulta</p>
                                <p class="text-gray-900">{{ appointment.reason }}</p>
                            </div>
                        </div>

                        <!-- Information Box -->
                        <div class="bg-gradient-to-r from-blue-50 to-medical-50 border-2 border-blue-200 rounded-2xl p-6 mb-8 text-left animate-slide-up" style="animation-delay: 0.4s;">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-blue-500 rounded-full p-2">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-gray-900 mb-3">Información Importante</h3>
                                    <ul class="space-y-2 text-gray-700">
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-health-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Revisa tu correo electrónico para más detalles</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-health-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Llega 10 minutos antes de tu cita</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-health-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Trae tus estudios médicos previos</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-health-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Para cancelar, comunícate al <strong class="text-medical-600">+52 123 456 7890</strong></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in" style="animation-delay: 0.5s;">
                            <Link :href="route('welcome')">
                                <button class="w-full sm:w-auto bg-gradient-to-r from-medical-500 to-health-600 text-white px-8 py-4 rounded-xl font-semibold hover:shadow-2xl transition-all hover:scale-105 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <span>Volver al Inicio</span>
                                </button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
