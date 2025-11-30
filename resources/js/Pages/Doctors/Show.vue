<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    doctor: Object,
    nextSlots: Array,
});

const bookSlot = (slot) => {
    router.visit(route('appointments.create', {
        doctor: props.doctor.slug,
        start: slot.start_time,
    }));
};
</script>

<template>
    <GuestLayout :title="doctor.name">
        <Head :title="doctor.name" />

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <Link :href="route('home')" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                            ← Volver
                        </Link>

                        <div class="mb-6">
                            <h1 class="text-3xl font-bold text-gray-900">{{ doctor.name }}</h1>
                            <p class="text-lg text-gray-600 mt-2">{{ doctor.specialty }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ doctor.email }}</p>
                            <p v-if="doctor.phone" class="text-sm text-gray-500">{{ doctor.phone }}</p>
                        </div>

                        <div v-if="doctor.bio" class="mb-6">
                            <h2 class="text-xl font-semibold mb-2">Sobre el Médico</h2>
                            <p class="text-gray-700">{{ doctor.bio }}</p>
                        </div>

                        <div v-if="nextSlots && nextSlots.length > 0">
                            <h2 class="text-xl font-semibold mb-4">Próximos Horarios Disponibles</h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <button
                                    v-for="slot in nextSlots"
                                    :key="slot.start_time"
                                    @click="bookSlot(slot)"
                                    class="p-3 bg-blue-100 hover:bg-blue-200 rounded-lg text-blue-800 text-center transition"
                                >
                                    <div class="font-semibold">
                                        {{ new Date(slot.start_time).toLocaleDateString('es-ES', { day: 'numeric', month: 'short' }) }}
                                    </div>
                                    <div class="text-sm">
                                        {{ new Date(slot.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

