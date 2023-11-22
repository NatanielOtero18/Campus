<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { useFlash } from '@/Composables/useFlash';
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'


const page = usePage()
const classroom = computed(() => page.props.classroom)
let { flash } = useFlash()


const form = useForm({
    name: page.props.classroom.name,
    quota: page.props.classroom.quota,

});

const submit = () => {
    console.log(form)
    form.patch(route('UpdateClassroom', page.props.classroom.id), { onFinish: () => { flash('Clase modificada!', 'La clase fue modificada correctamente', 'success') } })
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

            <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Modificar datos
            </PrimaryButton>
        </div>


    </form>
   
</template>
