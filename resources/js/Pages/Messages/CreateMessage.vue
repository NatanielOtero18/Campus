<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TabbableTextArea from '@/Components/TabbableTextArea.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { useFlash } from '@/Composables/useFlash.js'
import PrimaryButton from '@/Components/PrimaryButton.vue';

let { flash } = useFlash()

let { receiver, thread } = defineProps({
    receiver: Object, thread: {
        type: Object,
        default: null
    }
})

const form = useForm({
    'subject': '',
    'message': '',
    'recipient': receiver.id,
})

const submit = () => {
    if (thread !== null) {
        form.post(route('StoreMessage',thread.id), {
            preserveState: false,
            onFinish: () => {
                flash('Mensaje enviado!', 'Mensaje enviado correctamente', 'success'),
                    form.reset('subject', 'message')
            },
        })
    } else {
        form.post(route('StoreMessage'), {
            preserveState: false,
            onFinish: () => {
                flash('Mensaje enviado!', 'Mensaje enviado correctamente', 'success'),
                    form.reset('subject', 'message')
            },
        })
    }
}
</script>

<template>
    <Head title="Messages" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Contactar : {{ receiver.role.name }} </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                    <form @submit.prevent="submit" class="p-6 flex flex-col w-full">

                        <div class="mt-4">
                            <InputLabel for="subject" value="Asunto" />

                            <TextInput id="subject" type="text" class="mt-1 block w-full" v-model="form.subject" required
                                autofocus autocomplete="score" />

                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="message" value="Mensaje" />
                            <TabbableTextArea v-model="form.message" class="w-full" required />


                            <InputError class="mt-2" :message="form.errors.subject" />
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

    </AuthenticatedLayout>
</template>