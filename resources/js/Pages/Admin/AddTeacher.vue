<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { useFlash } from '@/Composables/useFlash.js'

import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'


const page = usePage()
const classrooms = computed(()=> page.props.avClassrooms)
let {flash} = useFlash()

const form = useForm({
    username:'',
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    classroom_id: '',
    contact_email : ''
});

const submit = () => {
    console.log(form)
    form.post(route('AddTeacher'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation'),
            flash('Teacher Agregado Agregado!', 'Se agrego correctamente al usuario', 'success')
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="p-4 flex-col justify-around items-center">
        <div>
            <InputLabel for="username" value="Username" />

            <TextInput id="username" type="text" class="mt-1 block w-full" v-model="form.username" required autofocus
                autocomplete="username" />

            <InputError class="mt-2" :message="form.errors.username" />
        </div>
        <div class="mt-4">
            <InputLabel for="name" value="Nombre" />

            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                autocomplete="name" />

            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
            <InputLabel for="email" value="Email" />

            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                autocomplete="username" />

            <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mt-4">
            <InputLabel for="classroom" value="Clase a cargo" />
            <select v-if="classrooms.length > 0" id="classroom" v-model="form.classroom_id" 
                class=" w-full p-2 border-gray-300 focus:border-black focus:ring-black rounded-md shadow-sm">
                <option v-for="classroom in classrooms" :value="classroom.id" :key="classroom.id">{{ classroom.name }}
                </option>
               
            </select>
            <div class="font-bold text-xs ml-4" v-else>
                No hay clases disponibles
            </div>


            <InputError class="mt-2" :message="form.errors.classroom" />
        </div>
        <div class="mt-4">
            <InputLabel for="conEmail" value="Email de contacto" />

            <TextInput id="conEmail" type="email" class="mt-1 block w-full" v-model="form.contact_email" required autofocus
                autocomplete="level" />

            <InputError class="mt-2" :message="form.errors.contact_email" />
        </div>

        <div class="mt-4">
            <InputLabel for="password" value="Password" />

            <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                autocomplete="new-password" />

            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
            <InputLabel for="password_confirmation" value="Confirm Password" />

            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                v-model="form.password_confirmation" required autocomplete="new-password" />

            <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <PrimaryButton class="w-full p-4 flex justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Confirmar
            </PrimaryButton>
        </div>
    </form>
</template>
