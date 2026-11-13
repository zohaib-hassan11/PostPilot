<script setup>
// Product brand mark (replaces the Mixpost logo). The name comes from APP_NAME (.env), so rebranding is one setting.
import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";

defineProps({
    // dark = white text (for the black sidebar); light = near-black text
    variant: {type: String, default: 'dark'},
    showName: {type: Boolean, default: true},
});
const page = usePage();
const name = computed(() => page.props.app?.name || 'Social Hub');
</script>
<template>
    <div class="flex items-center gap-3 select-none">
        <svg viewBox="0 0 40 40" class="h-10 w-10 shrink-0" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
                <linearGradient id="brandGrad" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#a676ff"/>
                    <stop offset="100%" stop-color="#6421d4"/>
                </linearGradient>
            </defs>
            <rect width="40" height="40" rx="11" fill="url(#brandGrad)"/>
            <!-- broadcast: one source, many destinations -->
            <circle cx="14" cy="20" r="3.2" fill="#fff"/>
            <path d="M20 13.5a9 9 0 0 1 0 13" stroke="#fff" stroke-width="2.4" fill="none" stroke-linecap="round"/>
            <path d="M24.5 9.5a14.5 14.5 0 0 1 0 21" stroke="#fff" stroke-opacity=".6" stroke-width="2.4" fill="none" stroke-linecap="round"/>
        </svg>
        <span v-if="showName"
              class="text-xl font-bold tracking-tight truncate"
              :class="variant === 'dark' ? 'text-white' : 'text-gray-900'">{{ name }}</span>
    </div>
</template>
