<script setup>
import { ref } from 'vue';

defineProps({
    tabs: Array,
    defaultTab : Number
})
const emit = defineEmits(['tabChanged'])
let openTab = ref(1)

let toggleTabs = (tabNumber) => {
    openTab.value = tabNumber
    emit('tabChanged',openTab.value)
}

</script>

<template>
    <div class="flex flex-wrap">
        <div class="w-full">
            <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                <li v-for="tab in tabs" :key="tab.id" class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <button class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal w-full"
                        @click="toggleTabs(tab.id)"
                        v-bind:class="{ 'text-black bg-white': openTab !== tab.id, 'text-white bg-black': openTab === tab.id}">
                        {{ tab.title }}
                    </button>
                </li>
            </ul>
           

        </div>
    </div>
</template>
