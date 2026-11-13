<script setup>
/**
 * UI/Badge — status pills. <Badge variant="success" dot>Published</Badge>
 * variants: neutral | primary | success | warning | danger | info | dark
 */
defineProps({
    variant: {type: String, default: 'neutral'},
    dot: {type: Boolean, default: false},
});
const V = {
    neutral: 'bg-gray-100 text-gray-700 ring-gray-200', primary: 'bg-indigo-50 text-indigo-700 ring-indigo-200',
    success: 'bg-emerald-50 text-emerald-700 ring-emerald-200', warning: 'bg-amber-50 text-amber-700 ring-amber-200',
    danger: 'bg-red-50 text-red-700 ring-red-200', error: 'bg-red-50 text-red-700 ring-red-200',
    info: 'bg-sky-50 text-sky-700 ring-sky-200', dark: 'bg-gray-900 text-white ring-gray-900',
};
const DOT = {neutral: 'bg-gray-400', primary: 'bg-indigo-500', success: 'bg-emerald-500', warning: 'bg-amber-500', danger: 'bg-red-500', error: 'bg-red-500', info: 'bg-sky-500', dark: 'bg-white'};
</script>
<template>
    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset whitespace-nowrap" :class="V[variant] ?? V.neutral">
        <span v-if="dot" class="w-1.5 h-1.5 rounded-full" :class="DOT[variant] ?? DOT.neutral"></span>
        <slot/>
    </span>
</template>
