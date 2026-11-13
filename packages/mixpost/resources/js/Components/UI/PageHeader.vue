<script setup>
/**
 * UI/PageHeader — every page starts with this.
 * <PageHeader title="Posts" eyebrow="Content"><template #description>…</template><template #actions><Button>New</Button></template></PageHeader>
 */
defineProps({
    title: {type: String, required: true},
    eyebrow: {type: String, default: null},
});
</script>
<template>
    <div class="row-px mb-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="min-w-0">
                <div v-if="eyebrow" class="mb-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-indigo-600">{{ eyebrow }}</div>
                <h1 class="text-[28px] leading-tight font-bold tracking-tight text-gray-900">{{ title }}</h1>
                <p v-if="$slots.description" class="mt-1.5 text-[15px] text-gray-500 max-w-[42rem]"><slot name="description"/></p>
            </div>
            <div v-if="$slots.actions" class="flex flex-wrap items-center gap-2 shrink-0"><slot name="actions"/></div>
        </div>
    </div>
</template>
