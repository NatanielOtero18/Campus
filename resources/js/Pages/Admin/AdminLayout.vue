<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import { Head, Link, router } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Admin" />

    <AuthenticatedLayout>
        <template #header >
            <div class="flex gap-8">
                <NavLink :href="route('AdminPanel')" :active="route().current('AdminPanel')"
                    class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</NavLink>

                <NavLink :href="route('AdminClasrooms')" :active="route().current('AdminClasrooms')"
                    class="font-semibold text-xl text-gray-800 leading-tight">Clases</NavLink>

            </div>
        </template>
        <slot />
    </AuthenticatedLayout>
</template>
