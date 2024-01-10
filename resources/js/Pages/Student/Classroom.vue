<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import UserTable from '@/Components/UserTable.vue';
import { Link, useForm } from '@inertiajs/vue3';
import TabbableTextArea from '@/Components/TabbableTextArea.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

let { classroom, teacher, messages } = defineProps({ classroom: Object, teacher: Object, messages: Array })

const form = useForm({
    message: '',
})
const submit = () => {
    form.post(route('SendClasroomMessage',classroom.id));
}


</script>

<template>
    <Head :title="classroom.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="w-full flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ classroom.name }} - Foro </h2>
                <Link :href="route('Message', { user: teacher.id })"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Contactar {{ teacher.name }}
                </Link>
            </div>

        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div id='scroll'
                            class="py-6 flex flex-col-reverse justify-start overflow-auto h-full gap-4 border border-gray-100"
                            scroll-region>
                            <div v-for="msg in messages" class="w-full bg-gray-100">
                                <div class="flex justify-evenly item-center px-4 py-2 flex-col ">
                                    <div class="flex min-w-0 gap-x-4 items-center justify-center basis-1/4">
                                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                            :src="`https://i.pravatar.cc/150?u=${msg.user.id}`" alt="">
                                        <div class="min-w-0 flex-auto">
                                            <p class="text-xl font-bold leading-6 text-gray-900">{{ msg.user.username }} :</p>                                           
                                        </div>
                                    </div>
                                    <div class="flex items-center basis-3/4 text-2xl p-4">
                                        {{ msg.message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                                    <form @submit.prevent="submit" class="px-6 flex flex-col w-full">

                                        <div class="mt-4">

                                            <TabbableTextArea v-model="form.message" class="w-full" required />


                                            <InputError class="mt-2" :message="form.errors.subject" />
                                        </div>

                                        <div class="flex items-center justify-end mt-4">

                                            <PrimaryButton class="w-full p-4 flex justify-center"
                                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Comentar
                                            </PrimaryButton>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout></template>