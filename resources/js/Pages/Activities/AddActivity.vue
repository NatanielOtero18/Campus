<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { useFlash } from '@/Composables/useFlash.js'
import { usePage } from '@inertiajs/vue3'
import TabbableTextArea from '@/Components/TabbableTextArea.vue';
import { computed } from 'vue'


const page = usePage()

let {flash} = useFlash()

const form = useForm({
   title : '',
   body : '',
   teacher_id: page.props.auth.user.role.id
});

const submit = () => {
   
    form.post(route('AddActivity'), {
        preserveState:false,
        onFinish: () => {
            flash('Activity Creada!', 'Se creo correctamente la actividad', 'success'),
            form.reset('title', 'body')         
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="p-4 flex-col justify-around items-center">
        <div>
            <InputLabel for="title" value="Encabezado" />

            <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required autofocus
                autocomplete="title" />

            <InputError class="mt-2" :message="form.errors.title" />
        </div>

        <div class="mt-4">
            <InputLabel for="body" value="Consigna" />
            <TabbableTextArea v-model="form.body" class="mt-1 block w-full" style="width: 100%; height: 300px;" required />
          

            <InputError class="mt-2" :message="form.errors.email" />
        </div>
      
        <div class="flex items-center justify-end mt-4">

            <PrimaryButton class="w-full p-4 flex justify-center" :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Crear Actividad
            </PrimaryButton>
        </div>
    </form>
</template>
