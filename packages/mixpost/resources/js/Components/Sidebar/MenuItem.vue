<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    url: {
        type: String,
        required: true
    },
    active: {
        type: Boolean,
        default: false
    },
    external: {
        type: Boolean,
        default: false
    },
    externalTarget: {
        type: String,
        default: '_self'
    }
});
</script>
<template>
    <template v-if="!external">
        <Link :href="url"
              class="relative py-2 px-sm rounded-lg flex flex-row items-center space-x-md rtl:space-x-reverse transition ease-in-out duration-200"
              :class="active ? 'bg-indigo-500/15 text-white ring-1 ring-inset ring-indigo-400/30' : 'text-white/55 hover:text-white hover:bg-white/5'">
            <div :class="active ? 'text-indigo-300' : ''">
                <slot name="icon"/>
            </div>
            <div class="font-medium tracking-tight rtl:tracking-normal">
                <slot/>
            </div>
        </Link>
    </template>

    <template v-else>
        <a :href="url" :target="externalTarget"
           class="py-2 px-sm rounded-lg flex flex-row items-center space-x-4 transition ease-in-out duration-200"
           :class="active ? 'bg-indigo-500/15 text-white' : 'text-white/55 hover:text-white hover:bg-white/5'">
            <div :class="active ? 'text-indigo-300' : ''">
                <slot name="icon"/>
            </div>
            <div class="font-medium tracking-tight rtl:tracking-normal">
                <slot/>
            </div>
        </a>
    </template>
</template>
