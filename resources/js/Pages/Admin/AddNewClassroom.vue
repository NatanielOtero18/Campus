<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { useFlash } from '@/Composables/useFlash';

let flash = useFlash()


const form = useForm({
    name: '', 
    quota: '',   
});

const submit = () => {
    console.log(form)
    form.post(route('AddClassroom'),{onFinish : () => { flash('Clase agregada!','La clase fue agregada correctamente','success')}})
};
</script>

<template>
    <form @submit.prevent="submit" class="p-4">
        <div>
            <InputLabel for="name" value="Nombre de la clase" />

            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                autocomplete="name" />

            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
            <InputLabel for="cupos" value="Cupos" />

            <TextInput id="cupos" type="number" class="mt-1 block w-full" v-model="form.quota" required autofocus
                autocomplete="cupos" />

            <InputError class="mt-2" :message="form.errors.quota" />
        </div>       
             

        <div class="flex items-center justify-end mt-4">

            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Agregar
            </PrimaryButton>
        </div>
    </form>
</template>
