<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
const quickLogin = (type) => {
    switch (type) {
        case 'admin':
            form.email = 'Admin@admin.com'
            form.password = '12345678'
            break;
        case 'stu':
            form.email = 'Student1@student.com'
            form.password = '123456'
            break;
        case 'tea':
            form.email = 'Teacher1@teacher.com'
            form.password = '123456'
            break;

        default:
            form.email = 'Admin@admin.com'
            form.password = '12345678'
            break;
    }
}
const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="email" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="current-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
            </div> -->

            <div class="flex items-center justify-end mt-4">


                <PrimaryButton class="w-full flex justify-center" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Iniciar sesión
                </PrimaryButton>

            </div>
        </form>
        <div class="flex justify-between mt-2 gap-2">

            <PrimaryButton @click="quickLogin('admin')" class="w-full flex justify-center" :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Admin
            </PrimaryButton>
            <PrimaryButton @click="quickLogin('tea')"  class=" w-full  flex justify-center" :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Teacher
            </PrimaryButton>
            <PrimaryButton @click="quickLogin('stu')"  class=" w-full  flex justify-center" :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Student
            </PrimaryButton>
        </div>
    </GuestLayout>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>