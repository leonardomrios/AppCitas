<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    doctors: Array,
    selectedDoctor: Object,
    appointments: Array,
    availableSlots: Array,
    weekStart: String,
    weekEnd: String,
});

const navigateWeek = (direction) => {
    const week = new Date(props.weekStart);
    week.setDate(week.getDate() + (direction === 'next' ? 7 : -7));
    
    router.get(route('calendar'), {
        doctor: props.selectedDoctor?.slug,
        week: week.toISOString().split('T')[0],
    });
};
</script>

<template>
    <AppLayout title="Calendario">
        <Head title="Calendario" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Calendario
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Doctor Filter -->
                <div class="mb-6">
                    <select
                        @change="router.get(route('calendar'), { doctor: $event.target.value })"
                        class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option :value="null">Seleccionar médico</option>
                        <option
                            v-for="doctor in doctors"
                            :key="doctor.id"
                            :value="doctor.slug"
                            :selected="selectedDoctor?.id === doctor.id"
                        >
                            {{ doctor.name }}
                        </option>
                    </select>
                </div>

                <!-- Week Navigation -->
                <div class="flex justify-between items-center mb-6">
                    <PrimaryButton @click="navigateWeek('prev')">Semana Anterior</PrimaryButton>
                    <span class="text-lg font-semibold">
                        {{ new Date(weekStart).toLocaleDateString('es-ES') }} - {{ new Date(weekEnd).toLocaleDateString('es-ES') }}
                    </span>
                    <PrimaryButton @click="navigateWeek('next')">Semana Siguiente</PrimaryButton>
                </div>

                <!-- Calendar Grid -->
                <div v-if="selectedDoctor" class="grid grid-cols-7 gap-2">
                    <div v-for="day in 7" :key="day" class="border rounded p-2 min-h-32">
                        <div class="font-semibold text-center mb-2">
                            {{ new Date(new Date(weekStart).setDate(new Date(weekStart).getDate() + day - 1)).toLocaleDateString('es-ES', { weekday: 'short', day: 'numeric' }) }}
                        </div>
                        <div class="space-y-1">
                            <div
                                v-for="appointment in appointments.filter(a => {
                                    const appointmentDate = new Date(a.start_time).toDateString();
                                    const dayDate = new Date(new Date(weekStart).setDate(new Date(weekStart).getDate() + day - 1)).toDateString();
                                    return appointmentDate === dayDate;
                                })"
                                :key="appointment.id"
                                :class="{
                                    'bg-yellow-200': appointment.status === 'pending',
                                    'bg-green-200': appointment.status === 'confirmed',
                                }"
                                class="text-xs p-1 rounded"
                            >
                                {{ new Date(appointment.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}
                                <br>
                                {{ appointment.patient_name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

