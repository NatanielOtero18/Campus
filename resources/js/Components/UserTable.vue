<script setup>
import ThePaginator from '@/Components/ThePaginator.vue';
import { router, usePage, Link, useForm } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue'
import Modal from '@/Components/Modal.vue';
import EditUser from '@/Pages/Admin/EditUser.vue';
import EditTeacher from '@/Pages/Admin/EditTeacher.vue';
import SecondaryButton from './SecondaryButton.vue';
import { useFlash } from '@/Composables/useFlash';
import { debounce } from 'lodash'

let { flash } = useFlash()
let user = usePage().props.auth.user;
let activities = usePage().props.activities;
let show = ref(false);
let showHM = ref(false);
let selectedUser = ref({})
let props = defineProps({
    users: Array,
    links: Array,
    query: String,
    objetive: String,
})

let search = ref(props.query);
watch(search, debounce((value) => {
    router.get(
        props.objetive, { search: value }, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    })

}))

const form = useForm({
    activity: {}
});

let assignActivity = (act) => {
    form.activity = act
    form.patch(route('AssingActivity', selectedUser.value.id), {
        onFinish: () => {
            flash('Activity Asignada!', 'Se asigno la actividad Nº: ' + act.id + ' a ' + selectedUser.value.name, 'success'),
                form.reset('activity')
        }
    })
}



let open = (user) => {
    show.value = true
    selectedUser.value = user
}

let homework = (user) => {
    if (user.membership == 1) {
        showHM.value = true
        selectedUser.value = user
    } else {
        flash('Error, Estudiante Inactivo', 'El estudiante no se encuentra activo en el sistema', 'error')
    }
}

const isTeacher = computed(() => {
    if (user.role_type != null) {

        return user.role_type.includes('Teacher')
    } else {
        return false
    }
})

const isAdmin = computed(() => { return user.isAdmin == 1 })



</script>

<template>
    <div class=" flex items-center justify-center flex-col">
        <div class="flex justify-center mt-4 p-4 w-full gap-2">
            <input type="text" name="search" placeholder="Search..." class="w-80" v-model="search">
            <slot />
        </div>
        <ul role="list" class="divide-y divide-gray-100 p-6 w-4/5 mx-32 ">
            <li v-for="user in users" :key="user.id" class="flex justify-between items-center gap-x-6 py-5 px-3"
                :class="{ 'bg-gray-100': user.membership != null && user.membership != 1 }">
                <div class="flex min-w-0 gap-x-4 items-center justify-center">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50" :src="`https://i.pravatar.cc/150?u=${user.id}`"
                        alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-xl font-bold leading-6 text-gray-900">{{ user.name }}</p>
                        <p v-if="user.membership != null" class="flex gap-2 text-sm font-semibold">Estado: {{
                            user.membership == 1 ? "Activo" : 'Inactivo' }}</p>
                    </div>
                </div>
                <div class="flex justify-evenly items-center  gap-4">
                    <div v-if="isAdmin" class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <Button @click="open(user)" class="text-sm leading-6 text-blue-500">Editar</Button>
                        <!-- :href="route('EditUser',user.id)" -->
                    </div>
                    <div v-if="isTeacher" class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <Button @click="homework(user)" class="text-sm leading-6 text-blue-500"
                            :class="{ 'disabled': user.membership == 0 }">Asignar tarea </Button>
                        <!-- :href="route('EditUser',user.id)" -->
                    </div>
                    <div v-if="isTeacher" class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <Link :href="route('CheckActivities', user.id)" class="text-sm leading-6 text-blue-500">Revisar
                        Actividades</Link>

                    </div>
                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <Link :href="route('Message', { user: user.id })" class="text-sm leading-6 text-blue-500">Contactar
                        </Link>

                    </div>
                </div>
            </li>

        </ul>
        <ThePaginator :links="links" />
    </div>
    <Modal :show="show" @close="show = false">
        <EditUser v-if="selectedUser.role === 'Student'" :user="selectedUser" />
        <EditTeacher v-else :user="selectedUser" />
    </Modal>
    <Modal :show="showHM" @close="showHM = false">
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col py-5 justify-center items-center">
                    <h2 class="font-bold text-xl p-2">Actividades: </h2>
                    <ul role="list" class="divide-y divide-gray-100 min-w-full  w-full px-12 py-6 mx-32 ">
                        <li v-for="act in activities.data" :key="act.id"
                            class="flex justify-evenly items-center gap-x-6 py-5 min-w-full  w-full">
                            <div>Actividad Nº: {{ act.id }}</div>
                            <div>{{ act.title }}</div>
                            <div>
                                <SecondaryButton @click="assignActivity(act)" type="button">Asignar</SecondaryButton>
                            </div>

                        </li>

                    </ul>

                    <ThePaginator class="mt-7" :links="activities.links" />

                </div>
            </div>
        </div>
    </Modal>
</template>
