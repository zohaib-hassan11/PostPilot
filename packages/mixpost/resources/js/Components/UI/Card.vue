<script setup>
/**
 * UI/Card — the standard surface (white, soft border, rounded-2xl).
 * <Card><template #title>Accounts</template><template #description>…</template><template #action><Button size="sm">Add</Button></template> body </Card>
 * padding: none | sm | md | lg ; interactive: hover lift (for clickable cards)
 */
defineProps({
    padding: {type: String, default: 'lg'},
    interactive: {type: Boolean, default: false},
});
const PAD = {none: '', sm: 'p-4', md: 'p-5', lg: 'p-6'};
</script>
<template>
    <div class="bg-white rounded-2xl ring-1 ring-gray-200/70 shadow-[0_1px_2px_rgba(16,16,32,.04),0_8px_24px_-12px_rgba(16,16,32,.08)]"
         :class="interactive ? 'transition hover:-translate-y-0.5 hover:ring-indigo-200 hover:shadow-[0_12px_32px_-12px_rgba(100,33,212,.25)]' : ''">
        <div :class="PAD[padding] ?? PAD.lg">
            <div v-if="$slots.title || $slots.action" class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <h3 v-if="$slots.title" class="text-base font-semibold text-gray-900 tracking-tight"><slot name="title"/></h3>
                    <p v-if="$slots.description" class="mt-1 text-sm text-gray-500"><slot name="description"/></p>
                </div>
                <div v-if="$slots.action" class="shrink-0"><slot name="action"/></div>
            </div>
            <p v-else-if="$slots.description" class="text-sm text-gray-500"><slot name="description"/></p>
            <div :class="{'mt-5': $slots.title || $slots.action || $slots.description}">
                <slot/>
            </div>
        </div>
        <div v-if="$slots.footer" class="px-6 py-4 border-t border-gray-100 bg-gray-50/60 rounded-b-2xl">
            <slot name="footer"/>
        </div>
    </div>
</template>
