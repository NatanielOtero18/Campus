<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'


let {activities} = defineProps({activities:Array})



</script>

<template>
    <Head title="Actividades" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Actividades : </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="activities"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col gap-4">


                    <Link :href="route('studentShowActivity',item.id)" v-for="item in activities" class="flex  p-4 gap-4 border border-gray-150 items-center justify-between text-2xl">


                        <div class="flex  basis-1/4">
                            <p class="font-bold">{{ item.title }}</p>
                        </div>
                        <div class="flex  basis-1/2">
                           <p class="font-bold" v-if="item.body.length < 40">{{ item.body }}</p>
                           <p class="font-bold " v-else>{{ item.body.slice(0,40) + '...' }} </p>
                        </div>
                        <div class="flex basis-1/4">
                           <p class="font-bold" v-if="item.task.devolution === null">{{ item.task.completed ? 'Entregado': 'Pendiente' }}</p> 
                           <p class="font-bold" v-else></p>                    
                       
                           <p class="font-bold"  v-if="item.task.devolution != null">Calificación: {{ item.task.score  }}</p>                             
                                                   
                        </div>

                    </Link>
                </div>
                <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full">
                    No hay actividades registradas
                </div>






            </div>


        </div>

    </AuthenticatedLayout>
    
</template>
