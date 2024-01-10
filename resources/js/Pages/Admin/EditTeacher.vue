<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { useFlash } from '@/Composables/useFlash.js'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'


const page = usePage()
let { flash } = useFlash();

const avClassrooms = computed(() => page.props.avClassrooms);

const submit = () => {
    console.log(form)
    form.patch(route('UpdateTeacher', props.user.id), {
        onFinish: () => flash('Usuario modificado!', 'Se modificaron correctamente los datos', 'success')
    });
};
const emit = defineEmits(['close'])

let props = defineProps({
    user: Object
})
console.log(props.user)
const form = useForm({    
    name: props.user.name,
    email: props.user.email,
    classroom_id: props.user.classroom_id,
    contact_email: props.user.contact_email,
})


</script>

<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="p-4 font-bold text-xl">Administrar Usuario</h1>
                <form @submit.prevent="submit" class="p-4">
                    <div>
                        <InputLabel for="name" value="Nombre" />

                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                            autocomplete="name" />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email" />

                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                            autocomplete="username" />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="classroom" value="Clase" />
                        <select id="classroom" v-model="form.classroom_id" v-if="avClassrooms.length > 0"
                            class=" w-full p-2 border-gray-300 focus:border-black focus:ring-black rounded-md shadow-sm">
                            <option :value="props.user.classroom_id">{{ props.user.classroom_name }}</option>
                            <option v-for="classroom in avClassrooms" :value="classroom.id" :key="classroom.id">{{
                                classroom.name }}</option>

                        </select>
                        <div class="font-bold text-xs ml-4" v-else>
                            No hay clases disponibles
                        </div>

                        <InputError class="mt-2" :message="form.errors.role" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="cemail" value="Email de contacto" />

                        <TextInput id="cemail" type="email" class="mt-1 block w-full" v-model="form.contact_email" required
                            autocomplete="username" />

                        <InputError class="mt-2" :message="form.errors.contact_email" />
                    </div>


                    <div class="flex items-center justify-end mt-4">

                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Guardar cambios
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>