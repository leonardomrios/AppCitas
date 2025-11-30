<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    pendingAppointments: Array,
    upcomingAppointments: Array,
    stats: Object,
    doctors: Array,
    selectedDoctor: Number,
});

const localSelectedDoctor = ref(props.selectedDoctor);

watch(() => props.selectedDoctor, (newValue) => {
    localSelectedDoctor.value = newValue;
});

const filterByDoctor = (doctorId) => {
    router.get(route('dashboard'), { doctor: doctorId || null }, {
        preserveState: true,
    });
};
</script>

<template>
    <AppLayout title="Dashboard">
        <Head title="Dashboard" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Filter -->
                <div class="mb-6">
                    <select
                        v-model="localSelectedDoctor"
                        @change="filterByDoctor($event.target.value)"
                        class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option :value="null">Todos los médicos</option>
                        <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
                            {{ doctor.name }}
                        </option>
                    </select>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="text-sm font-medium text-gray-500">Pendientes</div>
                            <div class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.pending }}</div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="text-sm font-medium text-gray-500">Próximas Confirmadas</div>
                            <div class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.confirmed }}</div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="text-sm font-medium text-gray-500">Completadas Hoy</div>
                            <div class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.completed_today }}</div>
                        </div>
                    </div>
                </div>

                <!-- Pending Appointments -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Citas Pendientes</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Médico</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="appointment in pendingAppointments" :key="appointment.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ appointment.patient_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ appointment.doctor.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ new Date(appointment.start_time).toLocaleString('es-ES') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <Link :href="route('appointments.show', appointment.slug)" class="text-blue-600 hover:text-blue-800 mr-2">
                                                Ver
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Appointments -->
                <div class="bg-white shadow rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Próximas Citas Confirmadas</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Médico</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="appointment in upcomingAppointments" :key="appointment.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ appointment.patient_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ appointment.doctor.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ new Date(appointment.start_time).toLocaleString('es-ES') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <Link :href="route('appointments.show', appointment.slug)" class="text-blue-600 hover:text-blue-800">
                                                Ver
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

