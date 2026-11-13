<script setup>
import {nextTick, onMounted, ref} from 'vue';

defineProps(['modelValue', 'error']);

defineEmits(['update:modelValue']);

const textarea = ref(null);

onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        nextTick(() => {
            textarea.value.focus();
        })
    }
});
</script>

<template>
    <textarea :value="modelValue"
              @input="$emit('update:modelValue', $event.target.value)"
              ref="textarea"
              :class="{'border-gray-200 bg-white': !error, 'border-red-600': error}"
              class="w-full rounded-lg shadow-xs focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/15 outline-hidden transition-colors ease-in-out duration-200"></textarea>
</template>
