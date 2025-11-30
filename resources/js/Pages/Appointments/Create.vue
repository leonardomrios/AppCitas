<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    doctor: Object,
    slotDate: String,
    slotTime: String,
    startTime: String,
});

const form = useForm({
    doctor_id: props.doctor?.id || null,
    patient_name: '',
    patient_email: '',
    patient_phone: '',
    reason: '',
    start_time: props.startTime || '',
});

const submit = () => {
    form.post(route('appointments.store'), {
        onSuccess: () => {
            // Success handled by redirect
        },
    });
};
</script>

<template>
    <GuestLayout title="Confirmar Cita">
        <Head title="Confirmar Cita Médica" />

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <Link :href="route('welcome')" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                            ← Volver
                        </Link>

                        <h1 class="text-2xl font-bold text-gray-900 mb-6">Confirmar Cita Médica</h1>

                        <div v-if="doctor" class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h2 class="font-semibold">{{ doctor.name }}</h2>
                            <p class="text-sm text-gray-600">{{ doctor.specialty }}</p>
                            <p v-if="slotDate && slotTime" class="mt-2 text-sm">
                                <strong>Fecha y Hora:</strong> {{ new Date(startTime).toLocaleString('es-ES') }}
                            </p>
                        </div>

                        <form @submit.prevent="submit">
                            <div class="space-y-4">
                                <div>
                                    <InputLabel for="patient_name" value="Nombre Completo" />
                                    <TextInput
                                        id="patient_name"
                                        v-model="form.patient_name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="form.errors.patient_name" />
                                </div>

                                <div>
                                    <InputLabel for="patient_email" value="Correo Electrónico" />
                                    <TextInput
                                        id="patient_email"
                                        v-model="form.patient_email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.patient_email" />
                                </div>

                                <div>
                                    <InputLabel for="patient_phone" value="Teléfono" />
                                    <TextInput
                                        id="patient_phone"
                                        v-model="form.patient_phone"
                                        type="tel"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.patient_phone" />
                                </div>

                                <div>
                                    <InputLabel for="reason" value="Motivo de la Consulta" />
                                    <textarea
                                        id="reason"
                                        v-model="form.reason"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        rows="4"
                                        required
                                    ></textarea>
                                    <InputError class="mt-2" :message="form.errors.reason" />
                                </div>

                                <InputError class="mt-2" :message="form.errors.start_time" />
                                <InputError class="mt-2" :message="form.errors.doctor_id" />

                                <div class="flex items-center justify-end mt-6">
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Confirmar Cita
                                    </PrimaryButton>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

