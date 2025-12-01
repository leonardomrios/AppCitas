<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    doctor: Object,
    nextSlots: Array,
});

const bookSlot = (slot) => {
    router.visit(route('appointments.create', {
        doctor: props.doctor.slug,
        start: slot.start_time,
    }));
};
</script>

<template>
    <GuestLayout :title="doctor.name">
        <Head :title="doctor.name" />

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <!-- Back Button -->
                <Link 
                    :href="route('welcome')" 
                    class="inline-flex items-center space-x-2 text-medical-600 hover:text-medical-700 mb-6 group"
                >
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-medium">Volver a la selección</span>
                </Link>

                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Header with Gradient -->
                    <div class="relative bg-gradient-to-br from-medical-600 via-medical-500 to-health-500 p-8 md:p-12">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        </div>

                        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                            <!-- Doctor Avatar -->
                            <div class="flex-shrink-0">
                                <div class="bg-white rounded-2xl p-6 shadow-2xl">
                                    <svg class="w-32 h-32 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Doctor Info -->
                            <div class="flex-1 text-white text-center md:text-left">
                                <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-1.5 rounded-full mb-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold">Especialista Certificado</span>
                                </div>
                                <h1 class="text-4xl md:text-5xl font-bold mb-3">{{ doctor.name }}</h1>
                                <div class="flex flex-col md:flex-row items-center gap-4 justify-center md:justify-start">
                                    <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-lg">
                                        <svg class="w-5 h-5 text-health-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <span class="font-medium">{{ doctor.specialty }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-8 md:p-12">
                        <!-- Contact Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="bg-gradient-to-br from-medical-50 to-health-50 rounded-xl p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Información de Contacto
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-white rounded-lg p-2 shadow-sm">
                                            <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Correo Electrónico</p>
                                            <p class="text-gray-900 font-medium">{{ doctor.email }}</p>
                                        </div>
                                    </div>
                                    <div v-if="doctor.phone" class="flex items-center space-x-3">
                                        <div class="bg-white rounded-lg p-2 shadow-sm">
                                            <svg class="w-5 h-5 text-health-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Teléfono</p>
                                            <p class="text-gray-900 font-medium">{{ doctor.phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-health-50 to-medical-50 rounded-xl p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-health-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Datos Rápidos
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between bg-white rounded-lg p-3 shadow-sm">
                                        <span class="text-gray-600">Especialidad</span>
                                        <span class="font-semibold text-gray-900">{{ doctor.specialty }}</span>
                                    </div>
                                    <div class="flex items-center justify-between bg-white rounded-lg p-3 shadow-sm">
                                        <span class="text-gray-600">Estado</span>
                                        <span class="inline-flex items-center space-x-1 text-health-600 font-semibold">
                                            <span class="flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-health-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-health-500"></span>
                                            </span>
                                            <span>Disponible</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bio Section -->
                        <div v-if="doctor.bio" class="mb-8">
                            <div class="bg-gradient-to-br from-gray-50 to-medical-50/20 rounded-xl p-6 border-l-4 border-medical-500">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Sobre el Doctor
                                </h3>
                                <p class="text-gray-700 leading-relaxed">{{ doctor.bio }}</p>
                            </div>
                        </div>

                        <!-- Available Slots -->
                        <div v-if="nextSlots && nextSlots.length > 0">
                            <div class="bg-gradient-to-r from-medical-600 to-health-600 rounded-xl p-6 mb-4">
                                <h2 class="text-2xl font-bold text-white flex items-center">
                                    <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Próximos Horarios Disponibles
                                </h2>
                                <p class="text-medical-100 mt-2">Selecciona un horario para agendar tu cita</p>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                <button
                                    v-for="slot in nextSlots"
                                    :key="slot.start_time"
                                    @click="bookSlot(slot)"
                                    class="group bg-white hover:bg-gradient-to-br hover:from-medical-500 hover:to-health-500 border-2 border-medical-200 hover:border-transparent rounded-xl p-4 transition-all hover:shadow-xl hover:scale-105"
                                >
                                    <div class="text-center">
                                        <div class="font-bold text-medical-600 group-hover:text-white transition-colors mb-1">
                                            {{ new Date(slot.start_time).toLocaleDateString('es-ES', { day: 'numeric', month: 'short' }) }}
                                        </div>
                                        <div class="text-sm text-gray-600 group-hover:text-white transition-colors">
                                            {{ new Date(slot.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}
                                        </div>
                                        <div class="mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-5 h-5 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </button>
                            </div>

                            <div class="mt-6 text-center">
                                <Link 
                                    :href="route('welcome', { doctor: doctor.slug })"
                                    class="inline-flex items-center space-x-2 text-medical-600 hover:text-medical-700 font-medium group"
                                >
                                    <span>Ver todos los horarios disponibles</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </Link>
                            </div>
                        </div>

                        <!-- <div v-else class="text-center py-12">
                            <div class="bg-gray-50 rounded-2xl p-8 max-w-md mx-auto">
                                <div class="bg-gray-200 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay horarios disponibles</h3>
                                <p class="text-gray-600 mb-4">Por favor, consulta el calendario completo para ver más opciones</p>
                                <Link 
                                    :href="route('welcome', { doctor: doctor.slug })"
                                    class="inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-medical-500 to-medical-600 text-white px-6 py-3 rounded-lg font-medium hover:shadow-lg transition-all hover:scale-105"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Ver Calendario Completo</span>
                                </Link>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

