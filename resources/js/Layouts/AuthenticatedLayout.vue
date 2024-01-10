<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link, usePage } from '@inertiajs/vue3';


const back = () => {
    window.history.back()
}

let user = usePage().props.auth.user
let unreadCount = usePage().props.unread

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex gap-8">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <div v-if="$page.props.auth.user.isAdmin">
                                    <Link :href="route('AdminTasks')">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                                    </Link>
                                </div>
                                <div v-else>
                                    <Link v-if="$page.props.auth.user.role_type.includes('Teacher')"
                                        :href="route('TeacherTasks')">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                                    </Link>
                                    <Link v-if="$page.props.auth.user.role_type.includes('Student')"
                                        :href="route('dashboard')">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                                    </Link>
                                </div>


                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden sm:-my-px sm:flex justify-center items-center">
                                <NavLink v-if="user.isAdmin" :href="route('AdminTasks')"
                                    :active="route().current('AdminTasks')">
                                    Home
                                </NavLink>
                                <div v-else>
                                    <NavLink v-if="user.role_type.includes('Teacher')" :href="route('TeacherTasks')"
                                        :active="route().current('TeacherTasks')">
                                        Home
                                    </NavLink>
                                    <NavLink v-if="user.role_type.includes('Student')" :href="route('dashboard')"
                                        :active="route().current('dashboard')">
                                        Home
                                    </NavLink>
                                </div>
                            </div>
                            <div v-if="user.isAdmin"
                                class="hidden sm:-my-px  sm:flex justify-center gap-8 items-center">
                                <NavLink :href="route('AdminPanel')"
                                    :active="route().current('AdminPanel') || route().current('AdminClasrooms')">
                                    Admin Panel
                                </NavLink>
                                <NavLink :href="route('AdminTickets')" :active="route().current('AdminTickets')">
                                    Tickets
                                </NavLink>
                            </div>
                            <div v-else class="hidden sm:-my-px gap-8  sm:flex justify-center items-center">
                                <div v-if="user.role_type.includes('Teacher')" class="flex justify-between items-center gap-6">

                                    <NavLink :href="route('TeacherClassroom')"
                                        :active="route().current('TeacherClassroom')">
                                        My Classroom
                                    </NavLink>

                                    <NavLink :href="route('TeacherActivities')"
                                        :active="route().current('TeacherActivities')">
                                        My Activities
                                    </NavLink>

                                </div>
                                <div v-else  class="flex justify-between items-center gap-6">
                                    <NavLink :href="route('StudentClassroom')"
                                        :active="route().current('StudentClassroom')">
                                        My Classroom
                                    </NavLink>

                                    <NavLink  :href="route('activities')"
                                        :active="route().current('activities')">
                                        My Activities
                                    </NavLink>
                                </div>                             

                            </div>
                            <div class="hidden space-x-8 sm:-my-px gap-8  sm:flex justify-center items-center">
                                    <NavLink class="notification" :href="route('ListThreads')"
                                        :active="route().current('ListThreads')">
                                        <!-- <p :class="{'text-red-300':unreadCount === 0}">My Messages</p> -->
                                        <span>My Messages</span>
                                        <span v-if="unreadCount > 0" class="badge" :class="'text-white bg-red-400 px-2 py-0.5'" >{{ unreadCount }}</span>
                                    </NavLink>
                                </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">

                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.username }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>

                                        <DropdownLink :href="route('profile.edit')"> Perfil </DropdownLink>
                                        <DropdownLink v-if="$page.props.auth.user.isAdmin == false"
                                            :href="route('MessageAdmin')"> Contactar Admin </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.username }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-4">
                        <button @click="back" class="rounded-full flex justify-between items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>


                        </button>
                        <slot name="header" />

                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
<style>
.notification {
   
  
    text-decoration: none;
    
    position: relative;
    display: inline-block;
    border-radius: 2px;
}


 .badge {
    position: absolute;
    top: -15px;
    right: -15px;
    border-radius: 50%;
    
}
</style>