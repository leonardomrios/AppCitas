<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    appointment: Object,
});
</script>

<template>
    <AppLayout title="Detalle de Cita">
        <Head title="Detalle de Cita" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle de Cita
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6">
                        <Link :href="route('appointments.index')" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                            ← Volver
                        </Link>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Paciente</label>
                                <p class="mt-1 text-sm text-gray-900">{{ appointment.patient_name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                <p class="mt-1 text-sm text-gray-900">{{ appointment.patient_email }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <p class="mt-1 text-sm text-gray-900">{{ appointment.patient_phone }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Médico</label>
                                <p class="mt-1 text-sm text-gray-900">{{ appointment.doctor.name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha y Hora</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ new Date(appointment.start_time).toLocaleString('es-ES') }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estado</label>
                                <span
                                    :class="{
                                        'bg-yellow-100 text-yellow-800': appointment.status === 'pending',
                                        'bg-green-100 text-green-800': appointment.status === 'confirmed',
                                        'bg-blue-100 text-blue-800': appointment.status === 'completed',
                                        'bg-red-100 text-red-800': appointment.status === 'rejected',
                                    }"
                                    class="mt-1 inline-flex px-2 py-1 text-xs leading-5 font-semibold rounded-full"
                                >
                                    {{ appointment.status }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Motivo</label>
                                <p class="mt-1 text-sm text-gray-900">{{ appointment.reason }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

