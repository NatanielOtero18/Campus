<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, usePage } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import StudentActivity from '@/Pages/Student/StudentActivity.vue';
import { router } from '@inertiajs/vue3'

let show = ref(false);
let selectedActivity = ref({});
let resolverActividad = (act) => {
    selectedActivity.value = act;
    show.value = true;

}
let closeAndRefresh = () => {
    show.value = false;
    router.reload()
}



let { activity } = defineProps({ activity: Object })

</script>

<template>
    <Head :title="activity.title" />
    <AuthenticatedLayout>
        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-96 bg-white overflow-hidden sm:rounded-lg flex flex-col mt-12 p-6 gap-4   ">


            <div class="basis-1/2">
                <div class="basis-1/4 gap-2 text-lg">
                    <p class="font-semibold gap-2">Actividad:  {{ activity.title }}</p>
                </div>
                <div class="gap-2 text-2xl ">
                    <p>{{ activity.body }}</p>

                </div>
            </div>
            <div class="basis-1/2 gap-2 text-2xl ">
                <PrimaryButton v-if="activity.task.completed == false" @click="resolverActividad(item)">
                    Resolver
                </PrimaryButton>
                <div v-else class="flex flex-col">
                    <div class="basis-1/2 gap-2 text-2xl flex items-center justify-center ">
                        <p class="font-semibold">Respuesta: {{ activity.task.submit }}</p>
                    </div>
                    <div class="basis-1/2 gap-2 text-2xl mt-4 flex" v-if="activity.task.devolution != null">
                       
                        <div class="basis-2/3 gap-2 text-2xl ">
                            <p>Devolución: {{ activity.task.devolution }}</p>

                        </div>
                        <div class="basis-1/3 gap-2 text-lg">
                            <p class="font-semibold">Calificación: {{ activity.task.score }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
    <Modal :show="show" @close="closeAndRefresh">
        <StudentActivity :selected-activity="selectedActivity" />
    </Modal>
</template>