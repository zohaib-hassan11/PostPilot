<script setup>
import {nextTick, onMounted, ref} from 'vue';

defineProps(['modelValue', 'error']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        nextTick(() => {
            input.value.focus();
        })
    }
});
</script>

<template>
    <input :value="modelValue"
           @input="$emit('update:modelValue', $event.target.value)"
           ref="input"
           :class="{'border-gray-200 bg-white': !error, 'border-red-600': error}"
           class="w-full rounded-lg shadow-xs focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/15 disabled:bg-gray-50 disabled:cursor-not-allowed outline-hidden transition-colors ease-in-out duration-200">
</template>
