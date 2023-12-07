<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { debounce } from 'lodash'


let search = ref('');
watch(search, debounce((value) => {
    router.get(
        route('AdminTickets'), { search: value }, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    })

}, 300))

let { tickets } = defineProps({ tickets: Array })

</script>

<template>
    <Head title="Tickets" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Tickets: </h2>
            <!-- <div class="w-full flex px-6  gap-4 justify-center">
                <PrimaryButton class="w-1/2 flex justify-center">Resueltos</PrimaryButton>
                <SecondaryButton  class="w-1/2 flex justify-center">Pendientes</SecondaryButton>
            </div> -->
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div v-if="tickets.length > 0"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 flex flex-col items-center">

                    <input type="text" name="search" placeholder="Search..." class="w-80" v-model="search">
                    <div class="w-full gap-6  grid grid-cols-3 p-6">

                        <div class="flex flex-col justify-center items-center border border-gray-500 gap-4 p-2 text-2xl"
                            v-for="item in tickets">

                            <div class="flex gap-2 grow">
                                de <p class="font-bold">{{ item.sender.role.name }}</p>: <p class="font-bold">{{
                                    item.subject }}
                                </p>
                            </div>
                            <div class="flex gap-2  grow">
                                {{ item.content.slice(0, 30) }} <p v-show="item.content.length > 30">...</p>
                            </div>
                            <div class="flex gap-2  grow">
                                Estado:
                                <p :class="{
                                    'text-red-400': item.solved === 0,
                                    'text-green-400 ': item.solved === 1
                                }">
                                    {{ item.solved == 0 ? "Pendiente" : "Resuelto" }}
                                </p>
                            </div>

                            <div class="grow-0">
                                <Link as="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" 
                                :href="route('Message', { user: item.sender.id, message: item.id })">{{
                                        item.solved === 0 ? "Resolver" : "Revisar" }}
                                </Link>
                              
                            </div>

                        </div>


                    </div>







                </div>
                <div  class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 " v-else>
                    No hay tickets en el sistema...
                </div>
            </div>


        </div>

    </AuthenticatedLayout>
</template>