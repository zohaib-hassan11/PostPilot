<script setup>
/**
 * UI/StatCard — one KPI. <StatCard label="Scheduled" :value="12" hint="next 7 days"><template #icon><CalendarIcon/></template></StatCard>
 */
defineProps({
    label: {type: String, required: true},
    value: {type: [String, Number], required: true},
    hint: {type: String, default: null},
    tone: {type: String, default: 'primary'},   // primary | success | warning | neutral
});
const TONE = {primary: 'from-indigo-500 to-indigo-700 shadow-indigo-600/25', success: 'from-emerald-500 to-emerald-600 shadow-emerald-600/25', warning: 'from-amber-400 to-amber-500 shadow-amber-500/25', neutral: 'from-gray-700 to-gray-900 shadow-gray-900/20'};
</script>
<template>
    <div class="bg-white rounded-2xl ring-1 ring-gray-200/70 p-5 shadow-[0_1px_2px_rgba(16,16,32,.04),0_8px_24px_-12px_rgba(16,16,32,.08)]">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-500">{{ label }}</span>
            <span v-if="$slots.icon" class="flex items-center justify-center w-9 h-9 rounded-xl text-white bg-gradient-to-br shadow-md [&>svg]:w-5 [&>svg]:h-5" :class="TONE[tone] ?? TONE.primary"><slot name="icon"/></span>
        </div>
        <div class="mt-3 text-3xl font-bold tracking-tight text-gray-900 tabular-nums">{{ value }}</div>
        <div v-if="hint" class="mt-1 text-xs text-gray-400">{{ hint }}</div>
    </div>
</template>
