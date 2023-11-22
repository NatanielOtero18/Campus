<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import ThePaginator from '@/Components/ThePaginator.vue';
import { ref, computed, watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';


let { activities, user, query } = defineProps({ activities: Object, user: Object, query: Object })

let show = ref(false);
let search = ref(query.search);

const formatDate = (date) => {
    let dt = new Date(date)
    return dt.getDate() + "/" + dt.getMonth() + "/" + dt.getFullYear()
}
watch(search, value => {
    router.get(
        route('CheckActivities', user.id), { search: value }, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    })

})
let completed = (task) => {
    if (task.completed === 0) {
        return 'No entregado'
    }
    else {
        if (task.score > 0)
            return task.score
        else {
            return 'Pendiente de corrección'
        }
    }
}

</script>

<template>
    <Head :title="'Activities'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> My Activities</h2>

        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div                   
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col py-5 px-5 justify-center items-center">
                <input type="text" name="search" placeholder="Search..." class="w-80" v-model="search">   
                <table class="table-auto w-full ">
                        <thead>
                            <th class="px-3 py-6">Actividad nº</th>
                            <th class="px-3 py-6">Titulo</th>
                            <th class="px-3 py-6">Enunciado</th>
                            <th class="px-3 py-6">Puntaje</th>
                            <th class="px-3 py-6">Modificado</th>
                            <th class="px-3 py-6">Acciones</th>
                        </thead>
                        <tbody>
                            <tr v-for="act in activities.data" :key="act.id">
                                <td class="px-6 py-3 text-center">{{ act.id }}</td>
                                <td class="px-6 py-3 text-center">{{ act.title }}</td>
                                <td class="px-6 py-3 text-center">{{ act.body }}</td>
                                <td class="px-6 py-3 text-center">{{ completed(act.task) }}</td>
                                <td class="px-6 py-3 text-center">{{ formatDate(act.updated_at) }}</td>
                                <td class="px-6 flex flex-col py-3 items-center justify-items-center">
                                    <Link :href="route('NeedsCorrection',{activity:act.id,user:user.role.id})" as="button" class=" inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" v-if="act.task.completed">
                                        <div v-if="act.task.score == 0">Corregir</div>
                                        <div v-else>Revisar Corrección</div>
                                    </Link>
                                    <h2 v-else>Esperando entrega...</h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <ThePaginator class="mt-12" :links="activities.links" />
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>