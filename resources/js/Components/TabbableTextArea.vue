<script setup>
defineProps({
    modelValue: String
});
let emit = defineEmits(['update:modelValue']);
function onTabPress(e) {
    let textarea = e.target;
    let val = textarea.value,
        start = textarea.selectionStart,
        end = textarea.selectionEnd;
    textarea.value = val.substring(0, start) + "\t" + val.substring(end);
    textarea.selectionStart = textarea.selectionEnd = start + 1;
}
</script>

<template>
    <textarea class="border-gray-300 focus:border-black focus:ring-black rounded-md shadow-sm"
        @keydown.tab.prevent="onTabPress" @input="emit('update:modelValue', $event.target.value)" v-text="modelValue" />
</template>