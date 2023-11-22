<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center sm:flex-col min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <img src="/assets/MClogo.svg" width="450" height="400" alt="">

            </div>
        </div>
        <div v-if="canLogin" class="text-2xl">
            <div v-if="$page.props.auth.user">
                <div v-if="$page.props.auth.user.isAdmin">
                    <Link :href="route('AdminTasks')"
                        class="font-semibold text-gray-600 hover:text-gray-900 hover:underline focus:outline focus:outline-2 focus:rounded-sm focus:outline-gray-400">
                    Continuar</Link>
                </div>
                <div v-else>
                    <Link v-if="$page.props.auth.user.role_type.includes('Teacher')" :href="route('TeacherTasks')"
                        class="font-semibold text-gray-600 hover:text-gray-900 hover:underline focus:outline focus:outline-2 focus:rounded-sm focus:outline-gray-400">
                    Continuar</Link>
                    <Link v-else :href="route('dashboard')"
                        class="font-semibold text-gray-600 hover:text-gray-900 hover:underline focus:outline focus:outline-2 focus:rounded-sm focus:outline-gray-400">
                    Continuar</Link>
                </div>
            </div>
            <Link v-else :href="route('login')"
                class="font-semibold text-gray-600 hover:text-gray-900 hover:underline focus:outline focus:outline-2 focus:rounded-sm focus:outline-gray-400">
            Iniciar sesión</Link>

        </div>



        <Link v-else :href="route('dashboard')"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
        Dashboard</Link>





    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
