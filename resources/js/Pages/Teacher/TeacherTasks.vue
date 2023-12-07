<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue'

let { pending } = defineProps({ pending: Array })
const pendingCorrection = computed(() => {
    return pending.filter(p => p.pending_correction.length > 0)
})

</script>

<template>
    <Head title="Teacher Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Pendiente de correccion </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-4 grid grid-cols-3 text-gray-900">
                        <div v-if="pendingCorrection.length == 0">No hay actividades pendietes de corrección...</div>
                        <div class="flex flex-col p-4  justify-items-center" v-for="item in pendingCorrection">
                          <h3 class="font-bold text-xl ">  Actvity: {{ item.id }} - {{ item.title }} :</h3>
                           
                           <p class="font-bold text-md mt-4"> Pending Correct:</p>
                            <div class="p-4 flex items-center justify-between text-lg " v-for="pen in item.pending_correction">
                                Student: {{ pen.name }}
                                <Link :href="route('NeedsCorrection', { activity: item.id, user: pen.id })" as="button"
                                    class=" inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Corregir

                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </AuthenticatedLayout>
</template>