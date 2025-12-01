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
const showModal = ref(false);

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
    showModal.value = true;
    loadSlots();
};

const closeModal = () => {
    showModal.value = false;
};

const bookAppointment = (slot) => {
    router.visit(route('appointments.create', {
        doctor: selectedDoctorData.value.slug,
        start: slot.start_time,
    }));
};

const getDoctorIcon = (specialty) => {
    return `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
    </svg>`;
};
</script>

<template>
    <GuestLayout title="Agendar Cita">
        <Head title="Agendar Cita Médica" />

        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-medical-600 via-medical-500 to-health-500 text-white relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
                <div class="text-center animate-fade-in">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6">
                        Cuida tu Salud Digestiva
                    </h1>
                    <p class="text-xl md:text-2xl text-medical-100 mb-8 max-w-3xl mx-auto">
                        Agenda tu cita con nuestros especialistas en gastroenterología. 
                        Atención profesional y personalizada para tu bienestar.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-6 py-3 rounded-full">
                            <svg class="w-6 h-6 text-health-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">+20 años de experiencia</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-6 py-3 rounded-full">
                            <svg class="w-6 h-6 text-health-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="font-medium">Especialistas certificados</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-16">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Doctor Selection -->
                <div class="mb-12 animate-slide-up">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">
                            Selecciona tu Médico Especialista
                        </h2>
                        <p class="text-lg text-gray-600">
                            Todos nuestros médicos están certificados y altamente calificados
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4">
                        <div
                            v-for="doctor in doctors"
                            :key="doctor.id"
                            :class="[
                                'group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden',
                                selectedDoctorSlug === doctor.slug
                                    ? 'ring-4 ring-medical-500 transform scale-105'
                                    : 'hover:transform hover:scale-105'
                            ]"
                        >
                            <!-- Doctor Image -->
                            <div 
                                @click="selectDoctor(doctor.slug)"
                                class="relative h-48 bg-gradient-to-br from-medical-100 to-health-100 flex items-center justify-center cursor-pointer"
                            >
                                <div :class="[
                                    'absolute inset-0 bg-gradient-to-br transition-opacity duration-300',
                                    selectedDoctorSlug === doctor.slug 
                                        ? 'from-medical-500/20 to-health-500/20' 
                                        : 'from-medical-400/10 to-health-400/10'
                                ]"></div>
                                <div :class="[
                                    'relative z-10 rounded-full p-8 transition-all duration-300',
                                    selectedDoctorSlug === doctor.slug 
                                        ? 'bg-white shadow-xl' 
                                        : 'bg-white/80 group-hover:bg-white group-hover:shadow-xl'
                                ]">
                                    <svg class="w-20 h-20 text-medical-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                
                                <!-- Selected Badge -->
                                <div v-if="selectedDoctorSlug === doctor.slug" 
                                     class="absolute top-4 right-4 bg-health-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center space-x-1 shadow-lg animate-scale-in">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Seleccionado</span>
                                </div>
                            </div>

                            <!-- Doctor Info -->
                            <div class="p-6">
                                <div @click="selectDoctor(doctor.slug)" class="cursor-pointer">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center">
                                        {{ doctor.name }}
                                        <svg v-if="selectedDoctorSlug === doctor.slug" class="w-5 h-5 ml-2 text-medical-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </h3>
                                    <div class="flex items-center space-x-2 text-medical-600 mb-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <span class="font-medium">{{ doctor.specialty }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4 flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ doctor.email }}</span>
                                    </p>
                                </div>
                                <Link 
                                    :href="`/doctors/${doctor.slug}`"
                                    class="text-medical-600 hover:text-medical-700 text-sm font-medium flex items-center space-x-1 group/link hover:underline"
                                    @click.stop
                                >
                                    <span>Ver perfil completo</span>
                                    <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Calendar -->
                <Transition
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="transition ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-if="showModal && selectedDoctorSlug" class="fixed inset-0 z-50 overflow-y-auto" @click="closeModal">
                        <!-- Backdrop -->
                        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

                        <!-- Modal Content -->
                        <div class="flex min-h-full items-center justify-center p-4">
                            <div 
                                @click.stop
                                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-7xl transform transition-all animate-scale-in"
                            >
                                <!-- Close Button -->
                                <button 
                                    @click="closeModal"
                                    class="absolute top-4 right-4 z-10 bg-white/90 hover:bg-white text-gray-600 hover:text-gray-900 rounded-full p-2 shadow-lg transition-all hover:scale-110"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <!-- Calendar -->
                                <div v-if="availableSlots.length > 0">
                                    <!-- Calendar Header -->
                                    <div class="bg-gradient-to-r from-medical-600 to-health-600 p-6 text-white rounded-t-2xl">
                                        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                                            <div>
                                                <h2 class="text-2xl font-bold mb-2">Horarios Disponibles</h2>
                                                <p class="text-medical-100">{{ selectedDoctorData?.name }}</p>
                                            </div>
                                            <div class="flex gap-3">
                                                <button 
                                                    @click="navigateWeek('prev')"
                                                    class="bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-2 rounded-lg font-medium transition-all hover:scale-105 flex items-center space-x-2"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                    </svg>
                                                    <span>Anterior</span>
                                                </button>
                                                <button 
                                                    @click="navigateWeek('next')"
                                                    class="bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-2 rounded-lg font-medium transition-all hover:scale-105 flex items-center space-x-2"
                                                >
                                                    <span>Siguiente</span>
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Calendar Grid -->
                                    <div class="p-6 max-h-[75vh] overflow-y-auto">
                                        <div class="grid grid-cols-2 md:grid-cols-7 gap-3">
                                            <div
                                                v-for="day in 7"
                                                :key="day"
                                                class="bg-gradient-to-br from-gray-50 to-medical-50/30 rounded-lg p-3 border border-gray-200"
                                            >
                                                <div class="font-bold text-center mb-2 pb-1.5 border-b border-medical-200">
                                                    <div class="text-xs text-gray-500 uppercase">
                                                        {{ new Date(new Date(currentWeekStart).setDate(new Date(currentWeekStart).getDate() + day - 1)).toLocaleDateString('es-ES', { weekday: 'short' }) }}
                                                    </div>
                                                    <div class="text-base text-gray-900">
                                                        {{ new Date(new Date(currentWeekStart).setDate(new Date(currentWeekStart).getDate() + day - 1)).toLocaleDateString('es-ES', { day: 'numeric', month: 'short' }) }}
                                                    </div>
                                                </div>
                                                <div class="space-y-1.5">
                                                    <button
                                                        v-for="slot in availableSlots.filter(s => {
                                                            const slotDate = new Date(s.start_time).toDateString();
                                                            const dayDate = new Date(new Date(currentWeekStart).setDate(new Date(currentWeekStart).getDate() + day - 1)).toDateString();
                                                            return slotDate === dayDate;
                                                        })"
                                                        :key="slot.start_time"
                                                        @click="bookAppointment(slot)"
                                                        class="w-full text-xs px-2.5 py-1.5 bg-gradient-to-r from-medical-500 to-medical-600 hover:from-medical-600 hover:to-health-600 text-white rounded-md transition-all hover:shadow-lg hover:scale-105 font-medium"
                                                    >
                                                        {{ new Date(slot.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}
                                                    </button>
                                                    <div v-if="availableSlots.filter(s => {
                                                        const slotDate = new Date(s.start_time).toDateString();
                                                        const dayDate = new Date(new Date(currentWeekStart).setDate(new Date(currentWeekStart).getDate() + day - 1)).toDateString();
                                                        return slotDate === dayDate;
                                                    }).length === 0" class="text-xs text-center text-gray-400 py-3">
                                                        No disponible
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- No slots available -->
                                <div v-else class="p-12 text-center">
                                    <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay horarios disponibles</h3>
                                    <p class="text-gray-600 mb-6">Intenta seleccionar otra semana</p>
                                    <button 
                                        @click="closeModal"
                                        class="bg-gradient-to-r from-medical-600 to-health-600 text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transition-all"
                                    >
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-gradient-to-br from-medical-50 to-health-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">¿Por qué elegirnos?</h2>
                    <p class="text-lg text-gray-600">Tu salud en las mejores manos</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="bg-gradient-to-br from-medical-500 to-medical-600 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Atención Inmediata</h3>
                        <p class="text-gray-600">Agenda tu cita en minutos y recibe confirmación al instante</p>
                    </div>
                    <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="bg-gradient-to-br from-health-500 to-health-600 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Especialistas Certificados</h3>
                        <p class="text-gray-600">Médicos con amplia experiencia y certificaciones internacionales</p>
                    </div>
                    <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="bg-gradient-to-br from-medical-500 to-health-600 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Atención Personalizada</h3>
                        <p class="text-gray-600">Tratamiento individualizado adaptado a tus necesidades</p>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

