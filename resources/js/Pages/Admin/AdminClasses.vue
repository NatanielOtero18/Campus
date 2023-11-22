<script setup>
import AdminLayout from './AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AddNewClassroom from './AddNewClassroom.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';


let showAddClassroom = ref(false);


let props = defineProps({ classrooms: Array })




</script>

<template>
    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <div class="  bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg divide-y divide-black">
                    <div class="flex justify-center">
                        <PrimaryButton class="w-full  flex justify-center" @click="showAddClassroom = true">
                            Agregar Clase</PrimaryButton>
                    </div>
                    <div class="grid grid-cols-2 mt-4 p-4 gap-4">
                        <Link as="button" :href="'/classInfo/' + classes.id"
                            class=" inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 w-full justify-evenly "
                            v-for="classes in props.classrooms">
                        <div>
                            Clase: {{ classes.name }}
                        </div>
                        <div v-if="classes.teacher_name">
                            Teacher: {{ classes.teacher_name }}
                        </div>
                        <div v-else>
                            Teacher: Vacante
                        </div>
                        <div>
                            Students: {{ classes.students_count }} / {{ classes.quota }}
                        </div>
                        </Link>
                    </div>




                </div>



            </div>
        </div>
    </AdminLayout>

    <Modal :show="showAddClassroom" @close="showAddClassroom = false">
        <AddNewClassroom :teachers="props.teachers" />
    </Modal>
</template>