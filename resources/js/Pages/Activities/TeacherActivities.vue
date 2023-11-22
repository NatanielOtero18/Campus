<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import ThePaginator from '@/Components/ThePaginator.vue';
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import AddActivity from './AddActivity.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EditActivity from './EditActivity.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

let selectedActivity = ref({})
let show = ref(false);
let showEdit = ref(false);
let { activities, query } = defineProps({ activities: Object , query : Object})
const formatDate = (date) => {
    let dt = new Date(date)
    return dt.getDate() + "/" + dt.getMonth() + "/" + dt.getFullYear()
}
let search = ref(query.search); 
watch(search, value => {
    router.get(
        route('TeacherActivities'), { search: value }, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    })

})
let openEdit = (acti) => {
    showEdit.value = true;
    selectedActivity.value = acti;
}
</script>

<template>
    <Head title="My Activities" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> My Activities</h2>

        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
               
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col py-5 justify-center items-center">
                    <div class="flex justify-center mt-4 p-4 w-full gap-2">
                        <input type="text" name="search" placeholder="Search..." class="w-80" v-model="search">
                        <PrimaryButton @click="show = true" class=" flex justify-center">Agregar Actividad
                        </PrimaryButton>
                    </div>
                    <table class="table-auto w-full mt-8">
                        <thead>
                            <th class="px-3 py-6">Actividad nº</th>
                            <th class="px-3 py-6">Titulo</th>
                            <th class="px-3 py-6">Enunciado</th>
                            <th class="px-3 py-6">Modificado</th>
                            <th class="px-3 py-6">Acciones</th>
                        </thead>
                        <tbody>
                            <tr v-for="act in activities.data" :key="act.id">
                                <td class="px-6 py-3 text-center">{{ act.id }}</td>
                                <td class="px-6 py-3 text-center">{{ act.title }}</td>
                                <td class="px-6 py-3 text-center">{{ act.body }}</td>
                                <td class="px-6 py-3 text-center">{{ formatDate(act.updated_at) }}</td>
                                <td class="px-6 py-3 text-center">
                                    <SecondaryButton @click="openEdit(act)" type="button">Editar</SecondaryButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <ul role="list" class="divide-y divide-gray-100  w-full px-12 py-6 mx-32 ">
                        <li v-for="act in activities.data" :key="act.id"
                            class="flex justify-between items-center gap-x-6 py-5 w-full">
                            <div>Actividad Nº: {{ act.id }}</div>
                            <div>{{ act.title }}</div>
                            <div>
                                {{ act.body }}
                            </div>
                            <div>
                                Modificado: {{ formatDate(act.updated_at) }}
                            </div>
                            <div>
                                <SecondaryButton @click="openEdit(act)" type="button">Editar</SecondaryButton>
                            </div>

                        </li>

                    </ul> -->

                    <ThePaginator class="mt-12" :links="activities.links" />

                </div>
            </div>
        </div>

    </AuthenticatedLayout>
    <Modal :show="show" @close="show = false">
        <AddActivity />
    </Modal>
    <Modal :show="showEdit" @close="showEdit = false">
        <EditActivity :activity="selectedActivity" />
    </Modal>
</template>