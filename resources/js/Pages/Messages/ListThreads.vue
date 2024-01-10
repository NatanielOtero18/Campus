<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

let {threads} = defineProps({threads:Array})

</script>

<template>
    <Head title="Messages" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Conversaciones </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                                        
                        <Link :href="route('ShowThread',item.id)" class=" flex py-4 px-8  justify-between w-full" v-for="item in threads">
                          <h3 class="font-bold text-xl flex gap-4 ">Asunto: {{ item.subject }} 
                             <span v-if="item.unreadCount > 0" class="rounded-full bg-red-400 text-white px-2.5">{{ item.unreadCount }}</span>
                            </h3> 
                           
                          <h3 class="font-bold text-xl flex gap-2 ">Miembros: <div v-for="(parti, index) in item.participants">
                                {{ parti.user.username }} <span v-if="index+1 < item.participants.length">, </span>
                          </div> </h3>   
                         
                        </Link>
                    
                </div>
            </div>


        </div>

    </AuthenticatedLayout>
</template>
<style>
.pr {
  color: grey; 
  overflow: hidden; 
  height: 50px;
  line-height: 16px; 
  position: relative;
  word-wrap: break-word;
}

.pr:after { content: "..."; background: #f3f5f6; position :absolute; right: 0; bottom: 2px;}




</style>