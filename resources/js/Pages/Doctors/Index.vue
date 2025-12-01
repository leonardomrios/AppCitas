<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Toast from '@/Components/Toast.vue';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    doctors: Array,
});

const page = usePage();
const errors = computed(() => page.props.errors || {});
const success = computed(() => page.props.flash?.success);

// Toast notifications
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref('success');

// Watch for flash messages
watch(success, (newValue) => {
    if (newValue) {
        toastMessage.value = newValue;
        toastType.value = 'success';
        showToast.value = true;
    }
});

// Watch for errors
watch(() => errors.value.delete, (newValue) => {
    if (newValue) {
        toastMessage.value = newValue;
        toastType.value = 'error';
        showToast.value = true;
    }
});

const deleteDoctor = (doctorSlug, doctorName) => {
    if (confirm(`¿Está seguro de eliminar al médico ${doctorName}?\n\nEsta acción no se puede deshacer.`)) {
        router.delete(route('doctors.destroy', doctorSlug));
    }
};
</script>

<template>
    <AppLayout title="Médicos">
        <Head title="Médicos" />

        <!-- Toast Notification -->
        <Toast
            :show="showToast"
            :message="toastMessage"
            :type="toastType"
            @close="showToast = false"
        />

        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Médicos
                </h2>
                <Link :href="route('doctors.create')">
                    <PrimaryButton>Nuevo Médico</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Especialidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="doctor in doctors" :key="doctor.id">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ doctor.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ doctor.email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ doctor.specialty }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <Link :href="route('doctors.edit', doctor.slug)" class="text-blue-600 hover:text-blue-900">
                                        Editar
                                    </Link>
                                    <button
                                        @click="deleteDoctor(doctor.slug, doctor.name)"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

