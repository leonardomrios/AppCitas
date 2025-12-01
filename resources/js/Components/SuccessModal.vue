<script setup>
import DialogModal from './DialogModal.vue';
import PrimaryButton from './PrimaryButton.vue';

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: '¡Éxito!',
    },
    message: {
        type: String,
        required: true,
    },
});

const emit = defineEmits(['close']);

const close = () => {
    emit('close');
};
</script>

<template>
    <DialogModal :show="show" @close="close" max-width="md">
        <template #title>
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ title }}
            </div>
        </template>

        <template #content>
            <div class="text-gray-600">
                {{ message }}
            </div>
        </template>

        <template #footer>
            <PrimaryButton @click="close">
                Entendido
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
