<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed } from 'vue';

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

// Combinar y ordenar citas y huecos por día y hora
const getEventsForDay = (day) => {
    const dayDate = new Date(new Date(props.weekStart).setDate(new Date(props.weekStart).getDate() + day - 1)).toDateString();
    
    // Obtener citas del día
    const dayAppointments = props.appointments
        .filter(a => new Date(a.start_time).toDateString() === dayDate)
        .map(a => ({
            type: 'appointment',
            time: new Date(a.start_time),
            data: a
        }));
    
    // Obtener huecos del día
    const daySlots = props.availableSlots
        .filter(s => new Date(s.start_time).toDateString() === dayDate)
        .map(s => ({
            type: 'slot',
            time: new Date(s.start_time),
            data: s
        }));
    
    // Combinar y ordenar por hora
    return [...dayAppointments, ...daySlots].sort((a, b) => a.time - b.time);
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
                            <!-- Eventos ordenados por hora -->
                            <template v-for="event in getEventsForDay(day)" :key="event.type + '-' + event.time">
                                <!-- Cita pendiente/confirmada -->
                                <div
                                    v-if="event.type === 'appointment'"
                                    :class="{
                                        'bg-yellow-200 border-yellow-400': event.data.status === 'pending',
                                        'bg-green-200 border-green-400': event.data.status === 'confirmed',
                                    }"
                                    class="text-xs p-1 rounded border-2"
                                >
                                    <div class="font-semibold">
                                        {{ event.time.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}
                                    </div>
                                    <div class="truncate">{{ event.data.patient_name }}</div>
                                    <div class="text-[10px] uppercase font-semibold">
                                        {{ event.data.status === 'pending' ? '⏳ Pendiente' : '✓ Confirmada' }}
                                    </div>
                                </div>
                                
                                <!-- Hueco disponible -->
                                <div
                                    v-else
                                    class="text-xs p-1 rounded bg-blue-50 border border-blue-200 text-blue-700"
                                >
                                    <div class="font-medium">
                                        {{ event.time.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}
                                    </div>
                                    <div class="text-[10px]">Disponible</div>
                                </div>
                            </template>
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

