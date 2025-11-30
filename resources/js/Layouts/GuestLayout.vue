<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    title: String,
});
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="min-h-screen bg-gray-50">
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')" class="text-xl font-bold text-blue-600">
                                    Clínica Gastroenterología
                                </Link>
                            </div>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <Link :href="route('home')" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900">
                                Inicio
                            </Link>
                            <Link v-if="$page.props.auth?.user" :href="route('dashboard')" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900">
                                Panel
                            </Link>
                            <Link v-else :href="route('login')" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900">
                                Iniciar Sesión
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

