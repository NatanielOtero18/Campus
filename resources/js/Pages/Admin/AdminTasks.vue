<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';

let { tickets } = defineProps({ tickets: Array })

</script>

<template>
    <Head title="Tickets" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Tickets pendientes: </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="tickets.length > 0"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 grid grid-cols-4 gap-4">


                    <Link  :href="route('SolveTicket',ticket.id)" v-for="ticket in tickets" class="flex flex-col p-4 gap-2 border border-gray-150 items-center justify-center text-2xl">


                        <div class="flex gap-2">
                            de: <p class="font-bold">{{ ticket.user.role.name }}</p>
                        </div>
                        <div class="flex gap-2">
                            Asunto: <p class="font-bold">{{ ticket.subject }}</p>
                        </div>
                        <div>

                          

                        </div>

                    </Link>
                </div>
                <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full">
                    No hay tickets pendientes...
                </div>






            </div>


        </div>

    </AuthenticatedLayout>
</template>