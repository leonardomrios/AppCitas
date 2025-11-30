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
                        <div class="font-semibold text-center mb-2 bg-gray-100 p-1 rounded">
                            {{ new Date(new Date(weekStart).setDate(new Date(weekStart).getDate() + day - 1)).toLocaleDateString('es-ES', { weekday: 'short', day: 'numeric', month: 'short' }) }}
                        </div>
                        <div class="space-y-1">
                            <!-- Citas pendientes/confirmadas -->
                            <div
                                v-for="appointment in appointments.filter(a => {
                                    const appointmentDate = new Date(a.start_time).toDateString();
                                    const dayDate = new Date(new Date(weekStart).setDate(new Date(weekStart).getDate() + day - 1)).toDateString();
                                    return appointmentDate === dayDate;
                                })"
                                :key="'apt-' + appointment.id"
                                :class="{
                                    'bg-yellow-200 border-yellow-400': appointment.status === 'pending',
                                    'bg-green-200 border-green-400': appointment.status === 'confirmed',
                                }"
                                class="text-xs p-1 rounded border-2"
                            >
                                <div class="font-semibold">
                                    {{ new Date(appointment.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}
                                </div>
                                <div class="truncate">{{ appointment.patient_name }}</div>
                                <div class="text-[10px] uppercase font-semibold">
                                    {{ appointment.status === 'pending' ? '⏳ Pendiente' : '✓ Confirmada' }}
                                </div>
                            </div>
                            
                            <!-- Huecos disponibles -->
                            <div
                                v-for="slot in availableSlots.filter(s => {
                                    const slotDate = new Date(s.start_time).toDateString();
                                    const dayDate = new Date(new Date(weekStart).setDate(new Date(weekStart).getDate() + day - 1)).toDateString();
                                    return slotDate === dayDate;
                                })"
                                :key="'slot-' + slot.start_time"
                                class="text-xs p-1 rounded bg-blue-50 border border-blue-200 text-blue-700"
                            >
                                <div class="font-medium">
                                    {{ new Date(slot.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}
                                </div>
                                <div class="text-[10px]">Disponible</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Leyenda -->
                <div v-if="selectedDoctor" class="mt-6 flex gap-4 justify-center text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-yellow-200 border-2 border-yellow-400 rounded"></div>
                        <span>Pendiente</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-200 border-2 border-green-400 rounded"></div>
                        <span>Confirmada</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-blue-50 border border-blue-200 rounded"></div>
                        <span>Disponible</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

