<script setup>
import AdminLayout from './AdminLayout.vue';
import UserTable from '@/Components/UserTable.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import EditClassroom from './EditClassroom.vue';
import { useForm, router } from '@inertiajs/vue3';
import { useFlash } from '@/Composables/useFlash.js'


let show = ref(false);
let showEdit = ref(false);
let { flash } = useFlash()

let props = defineProps({
    classroom: Object,
    classrooms: Object,
    teacher: Object,
    students: Array,
    query: Object,
    avTeachers: Object
})
const quota = props.students.data.length
const form = useForm({ teacher: '' })

const unassTea = () => {
    router.delete(route('UnTeacher', props.classroom.id), {
        onFinish: () => flash('Teacher desasignado!', 'Se modificaron correctamente los datos', 'success')
    });
}


let asignarTeacher = (teacher) => {
    console.log(teacher)
    form.teacher = teacher
    console.log(form)
    form.patch(route('AsTeacher', props.classroom.id), {
        onFinish: () => { flash('Teacher asignado!', 'Teacher asignado a ' + props.classroom.name, 'success'); show.value = false }
    });
}

</script>
<template>
    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <div class=" flex flex-col  bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg ">

                    <div class="flex justify-evenly mb-4 items-center">
                        <div>
                            Clase: {{ props.classroom.name }}
                        </div>
                        <SecondaryButton @click="show = true">
                            <div v-if="props.teacher.id" class="flex px-4 min-w-0 gap-x-4 items-center">
                                Teacher:
                                <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                    :src="`https://i.pravatar.cc/150?u=${props.teacher.id}`" alt="">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">{{ props.teacher.name }}</p>

                                </div>
                            </div>
                            <div v-else class="flex min-w-0 gap-x-4 items-center">
                                Teacher: Vacante
                            </div>
                        </SecondaryButton>

                        <div>
                            Cupos: {{ quota }} / {{ props.classroom.quota }}
                        </div>
                        <div>
                            <SecondaryButton @click="showEdit = true">Editar </SecondaryButton>
                        </div>
                    </div>
                    <div>
                        <UserTable :classrooms="props.classrooms" :objetive="route('ClassroomTable', props.classroom.id)"
                            :users="props.students.data" :links="props.students.links" :query="props.query.search" />
                    </div>



                </div>



            </div>
        </div>



    </AdminLayout>
    <Modal :show="show" @close="show = false">

        <div v-if="props.teacher.id">
            <div class="flex justify-center items-center p-4 mt-4">
                <div class="flex items-center text-lg min-w-0 gap-x-4">
                    Teacher asignado:
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        :src="`https://i.pravatar.cc/150?u=${props.teacher.id}`" alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">{{ props.teacher.name }}</p>

                    </div>
                </div>
            </div>
            <div class="p-5">
                <SecondaryButton class="w-full justify-center" @click="unassTea()">Desasignar Teacher</SecondaryButton>
            </div>
        </div>
        <div v-else>
            <div class="p-6" v-if="props.avTeachers.length > 0">
                <div class="font-bold text-md-center">
                    Teachers disponibles:
                </div>
                <div class="grid mt-5 gap-2">
                    <SecondaryButton class="justify-center " v-for="avTea in props.avTeachers"
                        @click="asignarTeacher(avTea)">
                        {{ avTea.user.role.name }}</SecondaryButton>
                </div>

            </div>
            <div v-else class="p-6 font-bold text-md-center">
                No hay teachers disponibles
            </div>
        </div>





    </Modal>
    <Modal :show="showEdit" @close="showEdit = false">
        <EditClassroom />
    </Modal>
</template>