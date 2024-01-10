<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router, useForm } from '@inertiajs/vue3';
import TabbableTextArea from '@/Components/TabbableTextArea.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { useFlash } from '@/Composables/useFlash.js'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted, onUpdated } from 'vue'

let { flash } = useFlash()
const user = usePage().props.auth.user
let { recipient, thread } = defineProps({
    recipient: Object, thread: {
        type: Object,
        default: null
    }
})

const form = useForm({
    'message': '',
    'recipient': recipient.id,
})
 
const submit = () => {
    if (thread !== null) {
        form.post(route('UpdateThread', thread.id), {
            preserveState: false,
            preserveScroll: true,
           
        })
    }
}




</script>

<template>
    <Head title="Conversacion" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Messages</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div id='scroll' class="p-6 flex flex-col-reverse justify-start overflow-auto h-64 gap-4 border border-gray-100"
                        scroll-region>
                        <div v-for="msg in thread.messages" class="w-full" :class="{
                            'flex justify-start': msg.user.id == user.id,
                            'flex justify-end': msg.user.id != user.id,
                        }">
                            <div class="flex flex-col bg-slate-50 rounded-3xl py-4 px-6">
                                <p class="text-s font-semibold text-gray-400">{{ msg.user.username }} : </p>
                                <p class="text-xl font-bold">{{ msg.body }}</p>
                            </div>
                        </div>

                    </div>
                    <div class="py-4">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                                <form @submit.prevent="submit" class="px-6 flex flex-col w-full">

                                    <div class="mt-4">
                                        <InputLabel for="message" value="Mensaje" />
                                        <TabbableTextArea v-model="form.message" class="w-full" required />


                                        <InputError class="mt-2" :message="form.errors.subject" />
                                    </div>

                                    <div class="flex items-center justify-end mt-4">

                                        <PrimaryButton class="w-full p-4 flex justify-center"
                                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Enviar
                                        </PrimaryButton>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>