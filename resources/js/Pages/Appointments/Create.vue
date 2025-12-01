<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    doctor: Object,
    slotDate: String,
    slotTime: String,
    startTime: String,
});

const form = useForm({
    doctor_id: props.doctor?.id || null,
    patient_name: '',
    patient_email: '',
    patient_phone: '',
    reason: '',
    start_time: props.startTime || '',
});

const submit = () => {
    form.post(route('appointments.store'), {
        onSuccess: () => {
            // Success handled by redirect
        },
    });
};
</script>

<template>
    <GuestLayout title="Confirmar Cita">
        <Head title="Confirmar Cita Médica" />

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <Link 
                    :href="route('welcome')" 
                    class="inline-flex items-center space-x-2 text-medical-600 hover:text-medical-700 mb-6 group"
                >
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-medium">Volver</span>
                </Link>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Form Section -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-medical-600 to-health-600 p-6 text-white">
                                <h1 class="text-3xl font-bold mb-2">Confirmar Cita Médica</h1>
                                <p class="text-medical-100">Completa tus datos para agendar tu cita</p>
                            </div>

                            <!-- Form -->
                            <form @submit.prevent="submit" class="p-6 space-y-6">
                                <div>
                                    <InputLabel for="patient_name" class="text-gray-700 font-semibold mb-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span>Nombre Completo</span>
                                        </div>
                                    </InputLabel>
                                    <TextInput
                                        id="patient_name"
                                        v-model="form.patient_name"
                                        type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-medical-500 focus:ring-medical-500 rounded-lg"
                                        placeholder="Ej: Juan Pérez García"
                                        required
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="form.errors.patient_name" />
                                </div>

                                <div>
                                    <InputLabel for="patient_email" class="text-gray-700 font-semibold mb-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>Correo Electrónico</span>
                                        </div>
                                    </InputLabel>
                                    <TextInput
                                        id="patient_email"
                                        v-model="form.patient_email"
                                        type="email"
                                        class="mt-1 block w-full border-gray-300 focus:border-medical-500 focus:ring-medical-500 rounded-lg"
                                        placeholder="ejemplo@correo.com"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.patient_email" />
                                </div>

                                <div>
                                    <InputLabel for="patient_phone" class="text-gray-700 font-semibold mb-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <span>Teléfono</span>
                                        </div>
                                    </InputLabel>
                                    <TextInput
                                        id="patient_phone"
                                        v-model="form.patient_phone"
                                        type="tel"
                                        class="mt-1 block w-full border-gray-300 focus:border-medical-500 focus:ring-medical-500 rounded-lg"
                                        placeholder="+52 123 456 7890"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.patient_phone" />
                                </div>

                                <div>
                                    <InputLabel for="reason" class="text-gray-700 font-semibold mb-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>Motivo de la Consulta</span>
                                        </div>
                                    </InputLabel>
                                    <textarea
                                        id="reason"
                                        v-model="form.reason"
                                        class="mt-1 block w-full border-gray-300 focus:border-medical-500 focus:ring-medical-500 rounded-lg"
                                        rows="4"
                                        placeholder="Describe brevemente el motivo de tu consulta..."
                                        required
                                    ></textarea>
                                    <InputError class="mt-2" :message="form.errors.reason" />
                                </div>

                                <InputError class="mt-2" :message="form.errors.start_time" />
                                <InputError class="mt-2" :message="form.errors.doctor_id" />

                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full bg-gradient-to-r from-medical-500 to-health-600 text-white px-6 py-4 rounded-xl font-semibold hover:shadow-xl transition-all hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                                >
                                    <svg v-if="!form.processing" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <svg v-else class="animate-spin w-6 h-6" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>{{ form.processing ? 'Procesando...' : 'Confirmar Cita' }}</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Summary Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-medical-50 to-health-50 rounded-2xl shadow-lg p-6 sticky top-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Resumen de la Cita
                            </h3>

                            <div v-if="doctor" class="space-y-4">
                                <!-- Doctor Info -->
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="bg-medical-100 rounded-full p-2">
                                            <svg class="w-6 h-6 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Médico</p>
                                            <p class="font-bold text-gray-900">{{ doctor.name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-medical-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <span>{{ doctor.specialty }}</span>
                                    </div>
                                </div>

                                <!-- Date & Time -->
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-health-100 rounded-full p-2">
                                            <svg class="w-6 h-6 text-health-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Fecha y Hora</p>
                                            <p class="font-bold text-gray-900">{{ new Date(startTime).toLocaleDateString('es-ES', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                                            <p class="text-medical-600 font-semibold mt-1">{{ new Date(startTime).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Important Info -->
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                    <div class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="text-sm text-blue-800">
                                            <p class="font-semibold mb-1">Importante:</p>
                                            <ul class="list-disc list-inside space-y-1 text-xs">
                                                <li>Recibirás un correo de confirmación</li>
                                                <li>Llega 10 min antes</li>
                                                <li>Trae tus estudios previos</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

