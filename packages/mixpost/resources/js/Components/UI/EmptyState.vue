<script setup>
/**
 * UI/EmptyState — friendly "nothing here yet" block with an optional action.
 * <EmptyState title="No posts yet" description="…"><template #icon><GridIcon/></template><template #actions><Button>Create</Button></template></EmptyState>
 */
defineProps({
    title: {type: String, required: true},
    description: {type: String, default: null},
});
</script>
<template>
    <div class="flex flex-col items-center text-center px-6 py-14">
        <div class="relative mb-5">
            <div class="absolute inset-0 rounded-2xl bg-indigo-500/20 blur-xl"></div>
            <div class="relative flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white shadow-lg shadow-indigo-600/30 [&>svg]:w-7 [&>svg]:h-7">
                <slot name="icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </slot>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 tracking-tight">{{ title }}</h3>
        <p v-if="description || $slots.default" class="mt-1.5 max-w-[26rem] text-sm text-gray-500"><slot>{{ description }}</slot></p>
        <div v-if="$slots.actions" class="mt-6 flex flex-wrap justify-center gap-2"><slot name="actions"/></div>
    </div>
</template>
