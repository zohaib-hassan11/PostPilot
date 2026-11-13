<script setup>
import {Link} from '@inertiajs/vue3';
defineProps({
    createUrl: {
        type: String,
        default: null
    }
});
</script>
<template>
    <div class="flex justify-between items-center">
        <div class="px-sm text-xs font-semibold uppercase tracking-widest text-white/35"><slot/></div>
        <template v-if="createUrl">
            <Link :href="createUrl" class="py-1 pr-sm text-white/35 hover:text-indigo-300 transition-colors ease-in-out duration-200">
                <slot name="icon" />
            </Link>
        </template>
    </div>
</template>
