<script setup>
import AdminLayout from './AdminLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue'
import AddStudent from './AddStudent.vue';
import AddTeacher from './AddTeacher.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import UserTable from '@/Components/UserTable.vue';
import TabsHeads from '@/Components/TabsHeads.vue';
import TabsBody from '@/Components/TabsBody.vue';

let show = ref(false);
let showProf = ref(false);

let openTab = ref(1);




const { students, teachers, query, classrooms, avClassrooms } = defineProps({
    students: Object,
    teachers: Object,
    query: Object,
    classrooms: Array,
    avClassrooms: Array
})

</script>

<template>
    <AdminLayout>       
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-gray-900">
                        <TabsHeads @tabChanged="(e) => openTab = e"
                            :tabs="[{ title: 'Students', id: 1 }, { title: 'Teachers', id: 2 }]" />
                        <TabsBody v-if="openTab === 1">
                            <UserTable :objetive="route('AdminPanel')" :users="students.data" :links="students.links"
                                :query="query.search">
                                <SecondaryButton @click="show = true">
                                    Alta Estudiante</SecondaryButton>

                            </UserTable>
                        </TabsBody>
                        <TabsBody v-if="openTab === 2">



                            <UserTable :objetive="route('AdminPanel')" :users="teachers.data" :links="teachers.links"
                                :query="query.search">
                                <SecondaryButton @click="showProf = true">
                                    Alta Profesor</SecondaryButton>
                            </UserTable>

                        </TabsBody>



                        <!-- 

                        -->
                    </div>

                </div>



            </div>
        </div>
    </AdminLayout>
    <Modal :show="show" @close="show = false">
        <AddStudent />
    </Modal>
    <Modal :show="showProf" @close="showProf = false">
        <AddTeacher />
    </Modal>
</template>