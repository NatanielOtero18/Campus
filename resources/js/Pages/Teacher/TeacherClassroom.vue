<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import UserTable from '@/Components/UserTable.vue';
import { usePage, useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue'
import Modal from '@/Components/Modal.vue';
import { useFlash } from '@/Composables/useFlash';

let { classroom, students, query } = defineProps({ classroom: Object, students: Object, query: String })
const page = usePage();
let { flash } = useFlash();
let activities = page.props.activities;
let show = ref(false);
let form = useForm({
    activity: {}
})

let assginAll = (act) => {
    form.activity = act

    form.patch(route('AssingToAll', classroom.id), {
        onFinish: () => {
            flash('Activity Asignada!', 'Se asigno la actividad Nº: ' + act.id + ' a toda la clase', 'success'),
                form.reset('activity')
        }
    })

}
</script>

<template>
    <Head :title="classroom.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> {{ classroom.name }}</h2>

        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-4 text-gray-900">
                        <UserTable :users="students.data" :links="students.links" :query="query"
                            :objetive="route('TeacherClassroom')">

                            <PrimaryButton @click="show = true" >Asignar actividad a
                                toda la clase</PrimaryButton>

                        </UserTable>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
    <Modal :show="show" @close="show = false">
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col py-5 justify-center items-center">
                    <h2 class="font-bold text-xl p-2">Actividades: </h2>
                    <ul role="list" class="divide-y divide-gray-100 min-w-full   w-full px-12 py-6 mx-32 ">
                        <li v-for="act in activities.data" :key="act.id"
                            class="flex justify-between items-center gap-x-6 py-5 ">
                            <div>Actividad Nº: {{ act.id }}</div>
                            <div>{{ act.title }}</div>
                            <div>
                                <SecondaryButton @click="assginAll(act)" type="button">Asignar</SecondaryButton>
                            </div>

                        </li>

                    </ul>

                    <ThePaginator class="mt-7" :links="activities.links" />

                </div>
            </div>
        </div>
    </Modal>
</template>