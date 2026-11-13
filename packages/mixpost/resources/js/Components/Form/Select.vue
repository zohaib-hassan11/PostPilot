<script setup>
import {nextTick, onMounted, ref} from 'vue';

defineProps(['modelValue', 'error']);

defineEmits(['update:modelValue']);

const select = ref(null);

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        nextTick(() => {
            select.value.focus();
        })
    }
});
</script>

<template>
    <select v-bind:value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
            ref="select"
            :class="{'border-gray-200 bg-white': !error, 'border-red-600': error}"
            class="w-full rounded-lg shadow-xs focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/15 outline-hidden transition-colors ease-in-out duration-200">
        <slot/>
    </select>
</template>
