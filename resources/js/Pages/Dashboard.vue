<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminTasks from '@/Pages/Admin/AdminTasks.vue';
import StudentTasks from '@/Pages/Student/StudentTasks.vue';
import TeacherTasks from './Teacher/TeacherTasks.vue';
import { Head, usePage } from '@inertiajs/vue3';

let user = usePage().props.auth.user

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
           
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Tasks</h2>
               
           
            
        </template>

        <div class="py-12">
          
        </div>
    </AuthenticatedLayout>
</template>
