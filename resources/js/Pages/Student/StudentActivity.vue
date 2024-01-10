<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TabbableTextArea from '@/Components/TabbableTextArea.vue';
import { useFlash } from '@/Composables/useFlash.js'

let { flash } = useFlash()



let { selectedActivity } = defineProps({ selectedActivity: Object })
const form = useForm({
    resp : ''
})
let submitForm = () =>{
    form.post(route('completeActivity',selectedActivity.id), {
            preserveState: false,
            onFinish: () => {
                flash('Actividad completada!', 'La actividad se entrego correctamente', 'success')
            },
        })
}
</script>

<template>
    <div
        class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-96 bg-white overflow-hidden sm:rounded-lg flex flex-col p-6 gap-4  items-center ">


        <div class="basis-1/4 gap-2 text-lg">
            <p class="font-semibold">{{ selectedActivity.title }}</p>
        </div>
        <div class="basis-1/2 gap-2 text-2xl " >
            <p >{{ selectedActivity.body }}</p>

        </div>
        <form @submit.prevent="submitForm" class="basis-1/4 gap-2 flex flex-col justify-center items-center w-full">
           
            <InputLabel for="resp" value="Respuesta" />

            <TabbableTextArea v-model="form.resp"  class="w-full"
                                 required />

            <InputError class="mt-2" :message="form.errors.resp" />
      
            <PrimaryButton>
                Confirmar
            </PrimaryButton>

        </form>









    </div>
</template>