<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import StudentActivity from '@/Pages/Student/StudentActivity.vue';
import { router } from '@inertiajs/vue3'


let {pendingActivities} = defineProps({pendingActivities:Array})


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Actividades pendientes: </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="pendingActivities.length > 0"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col gap-4">


                    <Link :href="route('studentShowActivity',item.id)" v-for="item in pendingActivities" class="flex  p-4 gap-2 border border-gray-150 items-center justify-between text-2xl">


                        <div class="flex gap-2">
                            <p class="font-bold">{{ item.title }}</p>
                        </div>
                        <div class="flex gap-2 ">
                           <p class="font-bold" v-if="item.body.length < 40">{{ item.body }}</p>
                           <p class="font-bold gap-2 inline-flex" v-else>{{ item.body.slice(0,40) + '...' }} </p>
                        </div>                        

                    </Link>
                </div>
                <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full">
                    No hay actividades pendientes...
                </div>






            </div>


        </div>

    </AuthenticatedLayout>
    
</template>
