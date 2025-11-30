<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    doctor: Object,
});

const form = useForm({
    name: props.doctor.name,
    email: props.doctor.email,
    phone: props.doctor.phone || '',
    specialty: props.doctor.specialty,
    bio: props.doctor.bio || '',
});

const submit = () => {
    form.put(route('doctors.update', props.doctor.id));
};
</script>

<template>
    <AppLayout title="Editar Médico">
        <Head title="Editar Médico" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Médico
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="space-y-4">
                                <div>
                                    <InputLabel for="name" value="Nombre" />
                                    <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div>
                                    <InputLabel for="email" value="Email" />
                                    <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required />
                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>

                                <div>
                                    <InputLabel for="phone" value="Teléfono" />
                                    <TextInput id="phone" v-model="form.phone" type="tel" class="mt-1 block w-full" />
                                    <InputError class="mt-2" :message="form.errors.phone" />
                                </div>

                                <div>
                                    <InputLabel for="specialty" value="Especialidad" />
                                    <TextInput id="specialty" v-model="form.specialty" type="text" class="mt-1 block w-full" required />
                                    <InputError class="mt-2" :message="form.errors.specialty" />
                                </div>

                                <div>
                                    <InputLabel for="bio" value="Biografía" />
                                    <textarea
                                        id="bio"
                                        v-model="form.bio"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        rows="4"
                                    ></textarea>
                                    <InputError class="mt-2" :message="form.errors.bio" />
                                </div>

                                <div class="flex items-center justify-end space-x-4">
                                    <Link :href="route('doctors.index')" class="text-gray-600 hover:text-gray-900">
                                        Cancelar
                                    </Link>
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Actualizar
                                    </PrimaryButton>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

