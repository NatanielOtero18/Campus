<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TabbableTextArea from '@/Components/TabbableTextArea.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { useFlash } from '@/Composables/useFlash.js'
import { ref, computed, watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';


let { activity, user } = defineProps({ activity: Object, user: Object })

let { flash } = useFlash()

const form = useForm({
    studentID : user.role.id,
    score: activity.task.score ,
    devolution: activity.task.devolution,
});

const submit = () => {
   
   form.patch(route('CorrectActivity',activity.id), {
       onFinish: () => {
           flash('Correccion realizada!', 'Se corrigio la actividad', 'success'),
           form.reset('score', 'correct')         
       },
   });
};
</script>

<template>
    <Head :title="'Activities'" />

    <AuthenticatedLayout>
        <template #header>
           
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-start items-center gap-12">
                <div>Student: {{ user.role.name }}</div>
                <div>Activity: Nº{{ activity.id }} - {{ activity.title }}</div>
                
            </h2>
              
        
        
         
        </template>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col py-5 px-5 justify-center items-center">
                    <div>Enunciado: {{ activity.body }}</div>
                    <br>
                    <div>
                        <h2>Respuesta del alumno:</h2>
                    </div>
                    <br>
                    <p>{{ activity.task.submit }}</p>
                             
                    <form @submit.prevent="submit"  class="flex flex-col w-full">


                        <div class="mt-4">
                            <InputLabel for="devolution" value="Correction" />
                            <TabbableTextArea v-model="form.devolution"  class="w-full"
                                 required />


                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="score" value="Score" />

                            <TextInput id="score" type="number" class="mt-1 block w-full" v-model="form.score" required
                                autofocus autocomplete="score" />

                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>
                        <div class="flex items-center justify-end mt-4">

                            <PrimaryButton class="w-full p-4 flex justify-center" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Confirmar
                            </PrimaryButton>
                        </div>
                    </form>
                  


                </div>
            </div>
        </div>
        
    </AuthenticatedLayout>
</template>