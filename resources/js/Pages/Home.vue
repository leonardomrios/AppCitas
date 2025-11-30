<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    doctors: Array,
    selectedDoctor: String,
    weekStart: String,
    availableSlots: Array,
});

const selectedDoctorSlug = ref(props.selectedDoctor);
const currentWeekStart = ref(props.weekStart);

const selectedDoctorData = computed(() => {
    return props.doctors.find(d => d.slug === selectedDoctorSlug.value);
});

const navigateWeek = (direction) => {
    const week = new Date(currentWeekStart.value);
    week.setDate(week.getDate() + (direction === 'next' ? 7 : -7));
    currentWeekStart.value = week.toISOString().split('T')[0];
    
    loadSlots();
};

const loadSlots = () => {
    router.get(route('welcome'), {
        doctor: selectedDoctorSlug.value,
        week: currentWeekStart.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

const selectDoctor = (slug) => {
    selectedDoctorSlug.value = slug;
    loadSlots();
};

const bookAppointment = (slot) => {
    router.visit(route('appointments.create', {
        doctor: selectedDoctorData.value.slug,
        start: slot.start_time,
    }));
};
</script>

<template>
    <GuestLayout title="Agendar Cita">
        <Head title="Agendar Cita Médica" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Agenda tu Cita Médica</h1>

                    <!-- Doctor Selection -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Selecciona un Médico</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div
                                v-for="doctor in doctors"
                                :key="doctor.id"
                                @click="selectDoctor(doctor.slug)"
                                :class="[
                                    'p-4 border-2 rounded-lg cursor-pointer transition',
                                    selectedDoctorSlug === doctor.slug
                                        ? 'border-blue-500 bg-blue-50'
                                        : 'border-gray-200 hover:border-blue-300'
                                ]"
                            >
                                <h3 class="font-semibold text-lg">{{ doctor.name }}</h3>
                                <p class="text-sm text-gray-600">{{ doctor.specialty }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ doctor.email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar -->
                    <div v-if="selectedDoctorSlug && availableSlots.length > 0" class="mt-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Horarios Disponibles</h2>
                            <div class="flex gap-2">
                                <PrimaryButton @click="navigateWeek('prev')">
                                    Anterior
                                </PrimaryButton>
                                <PrimaryButton @click="navigateWeek('next')">
                                    Siguiente
                                </PrimaryButton>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-7 gap-2">
                            <div
                                v-for="day in 7"
                                :key="day"
                                class="border rounded p-2"
                            >
                                <div class="font-semibold text-center mb-2">
                                    {{ new Date(new Date(currentWeekStart).setDate(new Date(currentWeekStart).getDate() + day - 1)).toLocaleDateString('es-ES', { weekday: 'short', day: 'numeric' }) }}
                                </div>
                                <div class="space-y-1">
                                    <button
                                        v-for="slot in availableSlots.filter(s => {
                                            const slotDate = new Date(s.start_time).toDateString();
                                            const dayDate = new Date(new Date(currentWeekStart).setDate(new Date(currentWeekStart).getDate() + day - 1)).toDateString();
                                            return slotDate === dayDate;
                                        })"
                                        :key="slot.start_time"
                                        @click="bookAppointment(slot)"
                                        class="w-full text-xs px-2 py-1 bg-blue-100 hover:bg-blue-200 rounded text-blue-800"
                                    >
                                        {{ new Date(slot.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else-if="selectedDoctorSlug" class="text-center text-gray-500 mt-8">
                        No hay horarios disponibles para esta semana.
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

