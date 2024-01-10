<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TabbableTextArea from '@/Components/TabbableTextArea.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

let { ticket, thread } = defineProps({ ticket: Object, thread: Object })
const user = usePage().props.auth.user;

const form = useForm({
    'message': '',
    'recipient': ticket.user.id,
})
const submit = () => {
    form.post(route('UpdateThread', thread.id));
}

const solveTicket = () => {
    form.patch(route('SetSolved',ticket.id))
}
</script>

<template>
    <Head title="Tickets" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center w-full">
                <div class="font-semibold text-xl text-gray-800 leading-tight">Ticket: {{ ticket.subject }} de {{
                    ticket.user.role.name }}
                </div>

                <div>
                    <PrimaryButton @click="solveTicket" class="flex justify-center items-center">Marcar como resuelto</PrimaryButton>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col  gap-4 p-6">

                    <div class="p-6 font-semibold text-2xl flex flex-col justify-center items-center">

                        <p> {{ ticket.content }}</p>


                    </div>
                    <div v-if="thread.messages.length > 0" 
                        class="p-6 flex flex-col-reverse justify-start overflow-auto h-64 gap-4 border border-gray-100"
                        scroll-region>
                        <div  v-for="msg in thread.messages" class="w-full" :class="{
                            'flex justify-start': msg.user.id == user.id,
                            'flex justify-end': msg.user.id != user.id,
                        }">
                            <div class="flex flex-col bg-slate-50 rounded-3xl py-4 px-6">
                                <p class="text-s font-semibold text-gray-400">{{ msg.user.username }} : </p>
                                <p class="text-xl font-bold">{{ msg.body }}</p>
                            </div>
                        </div>

                    </div>

                    <div>
                        <form @submit.prevent="submit" class="p-6 flex flex-col w-full">

                            <div class="mt-4">
                                <InputLabel for="message" value="Mensaje" />
                                <TabbableTextArea v-model="form.message" class="w-full" required />


                                <InputError class="mt-2" :message="form.errors.subject" />
                            </div>

                            <div class="flex items-center justify-end mt-4">

                                <PrimaryButton class="w-full p-4 flex justify-center"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Enviar Mensaje
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>

                </div>
            </div>







        </div>

    </AuthenticatedLayout>
</template>