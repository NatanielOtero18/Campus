<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { useFlash } from '@/Composables/useFlash.js'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TabbableTextArea from '@/Components/TabbableTextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';


let { flash } = useFlash()
const page = usePage();


const form = useForm({
    subject: '',
    content: ''   
})

const submit = () => {
    form.post(route('SendTicket'), {
        preserveState: false,
        onFinish: () => {
            flash('Mensaje Enviado!', 'Se envio el mensaje correctamente!', 'success'),
                form.reset('subject', 'content')
        },
    })
}
</script>

<template>
    <Head title="Contacto" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Contactar Administrador </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                   
                    <form @submit.prevent="submit" class="flex flex-col w-full p-4">

                        <div class="mt-2">
                            <InputLabel for="subject" value="Asunto" />
                            <TextInput id="subject" type="text" class="mt-1 block w-full" v-model="form.subject" required
                                autofocus autocomplete="subject" />



                            <InputError class="mt-2" :message="form.errors.subject" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="content" value="Mensaje" />
                            <TabbableTextArea v-model="form.content" class="w-full h-36" required />


                            <InputError class="mt-2" :message="form.errors.content" />
                        </div>
                        <div class="flex items-center justify-end mt-4">

                            <PrimaryButton class="w-full p-4 flex justify-center" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Enviar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    </AuthenticatedLayout></template>