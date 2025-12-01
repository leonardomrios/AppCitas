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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Citas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Filters -->
                <div class="bg-white shadow rounded-lg mb-6 p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Médico</label>
                            <select
                                v-model="filters.doctor"
                                @change="filterAppointments"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option :value="null">Todos</option>
                                <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
                                    {{ doctor.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                            <select
                                v-model="filters.status"
                                @change="filterAppointments"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option :value="null">Todos</option>
                                <option value="pending">Pendiente</option>
                                <option value="confirmed">Confirmada</option>
                                <option value="completed">Completada</option>
                                <option value="rejected">Rechazada</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Appointments Table -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Médico</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha/Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="appointment in appointments.data" :key="appointment.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ appointment.patient_name }}</div>
                                    <div class="text-sm text-gray-500">{{ appointment.patient_email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ appointment.doctor.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ new Date(appointment.start_time).toLocaleString('es-ES') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        :class="{
                                            'bg-yellow-100 text-yellow-800': appointment.status === 'pending',
                                            'bg-green-100 text-green-800': appointment.status === 'confirmed',
                                            'bg-blue-100 text-blue-800': appointment.status === 'completed',
                                            'bg-red-100 text-red-800': appointment.status === 'rejected',
                                        }"
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                    >
                                        {{ appointment.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <Link :href="route('appointments.show', appointment.slug)" class="text-blue-600 hover:text-blue-900">
                                        Ver
                                    </Link>
                                    <template v-if="appointment.status === 'pending'">
                                        <button @click="acceptAppointment(appointment.slug)" class="text-green-600 hover:text-green-900">
                                            Aceptar
                                        </button>
                                        <button @click="rejectAppointment(appointment.slug)" class="text-red-600 hover:text-red-900">
                                            Rechazar
                                        </button>
                                    </template>
    <button 
        v-if="appointment.status === 'confirmed' || appointment.status === 'pending'"
        @click="handleCancel(appointment.slug)"
        class="inline-flex items-center px-3 py-1.5 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
        Cancelar
    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

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

