<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Toast from '@/Components/Toast.vue';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    appointments: Object,
    doctors: Array,
    filters: Object,
});

const page = usePage();
const success = computed(() => page.props.flash?.success);
const errors = computed(() => page.props.errors || {});

// Toast notifications
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref('success');

// Watch for flash messages
watch(success, (newValue) => {
    if (newValue) {
        toastMessage.value = newValue;
        toastType.value = 'success';
        showToast.value = true;
    }
});

// Watch for errors
watch(() => errors.value.error, (newValue) => {
    if (newValue) {
        toastMessage.value = newValue;
        toastType.value = 'error';
        showToast.value = true;
    }
});

const acceptAppointment = (slug) => {
    router.post(route('appointments.accept', slug), {}, {
        preserveScroll: true,
    });
};

const rejectAppointment = (slug) => {
    if (confirm('¿Estás seguro de rechazar esta cita?')) {
        router.post(route('appointments.reject', slug), {}, {
            preserveScroll: true,
        });
    }
};

const handleCancel = (slug) => {
    if (confirm('¿Estás seguro de que deseas cancelar esta cita?')) {
        router.post(`/appointments/${slug}/cancel`, {}, {
            onSuccess: () => {
                // Recargar datos o mostrar mensaje
            }
        });
    }
};

const filterAppointments = () => {
    router.get(route('appointments.index'), props.filters, {
        preserveState: true,
    });
};
</script>

<template>
    <AppLayout title="Gestión de Citas">
        <Head title="Gestión de Citas" />

        <!-- Toast Notification -->
        <Toast
            :show="showToast"
            :message="toastMessage"
            :type="toastType"
            @close="showToast = false"
        />

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-2xl text-gray-900 flex items-center">
                    <svg class="w-7 h-7 mr-3 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Gestión de Citas
                </h2>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Filters -->
                <div class="bg-white shadow-lg rounded-2xl mb-6 p-6 border border-medical-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filtros
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Médico</label>
                            <select
                                v-model="filters.doctor"
                                @change="filterAppointments"
                                class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-medical-500 focus:ring-medical-500 transition"
                            >
                                <option :value="null">Todos los médicos</option>
                                <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
                                    {{ doctor.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select
                                v-model="filters.status"
                                @change="filterAppointments"
                                class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-medical-500 focus:ring-medical-500 transition"
                            >
                                <option :value="null">Todos los estados</option>
                                <option value="pending">Pendiente</option>
                                <option value="confirmed">Confirmada</option>
                                <option value="completed">Completada</option>
                                <option value="rejected">Rechazada</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Appointments Table -->
                <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-medical-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-medical-600 to-health-600">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Paciente</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Médico</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Fecha/Hora</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="appointment in appointments.data" :key="appointment.id" class="hover:bg-medical-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-medical-100 to-health-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">{{ appointment.patient_name }}</div>
                                                <div class="text-xs text-gray-500">{{ appointment.patient_email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ appointment.doctor.name }}</div>
                                        <div class="text-xs text-medical-600">{{ appointment.doctor.specialty }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ new Date(appointment.start_time).toLocaleDateString('es-ES') }}</div>
                                        <div class="text-xs text-gray-500">{{ new Date(appointment.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            :class="{
                                                'bg-yellow-100 text-yellow-800 ring-yellow-600/20': appointment.status === 'pending',
                                                'bg-green-100 text-green-800 ring-green-600/20': appointment.status === 'confirmed',
                                                'bg-blue-100 text-blue-800 ring-blue-600/20': appointment.status === 'completed',
                                                'bg-red-100 text-red-800 ring-red-600/20': appointment.status === 'rejected',
                                            }"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ring-1 ring-inset"
                                        >
                                            <span class="w-1.5 h-1.5 mr-1.5 rounded-full"
                                                :class="{
                                                    'bg-yellow-600': appointment.status === 'pending',
                                                    'bg-green-600': appointment.status === 'confirmed',
                                                    'bg-blue-600': appointment.status === 'completed',
                                                    'bg-red-600': appointment.status === 'rejected',
                                                }">
                                            </span>
                                            {{ appointment.status === 'pending' ? 'Pendiente' : 
                                               appointment.status === 'confirmed' ? 'Confirmada' :
                                               appointment.status === 'completed' ? 'Completada' : 'Rechazada' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <Link :href="route('appointments.show', appointment.slug)" class="inline-flex items-center px-3 py-1.5 bg-medical-100 text-medical-700 rounded-lg hover:bg-medical-200 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver
                                        </Link>
                                        <template v-if="appointment.status === 'pending'">
                                            <button @click="acceptAppointment(appointment.slug)" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Aceptar
                                            </button>
                                            <button @click="rejectAppointment(appointment.slug)" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Rechazar
                                            </button>
                                        </template>
                                        <button 
                                            v-if="appointment.status === 'confirmed' || appointment.status === 'pending'"
                                            @click="handleCancel(appointment.slug)"
                                            class="inline-flex items-center px-3 py-1.5 bg-orange-100 text-orange-700 rounded-lg hover:bg-orange-200 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Cancelar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="appointments.links" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <Link
                                    v-if="appointments.links.prev"
                                    :href="appointments.links.prev"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    Anterior
                                </Link>
                                <Link
                                    v-if="appointments.links.next"
                                    :href="appointments.links.next"
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    Siguiente
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

