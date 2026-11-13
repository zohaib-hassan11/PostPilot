<script setup>
/**
 * UI/Button — the ONE button of the app. Every other button component wraps this.
 *
 * <Button>Save</Button>
 * <Button variant="secondary" size="sm" :href="route('x')">Open</Button>   (renders an Inertia <Link>)
 * <Button variant="danger" :loading="form.processing" @click="destroy"><template #icon><TrashIcon/></template>Delete</Button>
 *
 * variants: primary | secondary | dark | danger | warning | soft | ghost
 * sizes:    xs | sm | md | lg
 */
import {computed} from "vue";
import {Link} from "@inertiajs/vue3";
import CircleLoadingIcon from "@/Icons/CircleLoading.vue";

const props = defineProps({
    variant: {type: String, default: 'primary'},
    size: {type: String, default: 'md'},
    type: {type: String, default: 'button'},
    href: {type: String, default: null},
    method: {type: String, default: 'get'},
    as: {type: String, default: 'a'},
    loading: {type: Boolean, default: false},
    disabled: {type: Boolean, default: false},
    block: {type: Boolean, default: false},
    hiddenTextOnSmallScreen: {type: Boolean, default: false},
});

const VARIANTS = {
    primary: 'text-white bg-gradient-to-b from-indigo-500 to-indigo-600 shadow-sm shadow-indigo-600/25 ring-1 ring-inset ring-white/10 hover:from-indigo-400 hover:to-indigo-500 focus-visible:ring-4 focus-visible:ring-indigo-500/30',
    secondary: 'text-gray-800 bg-white ring-1 ring-inset ring-gray-200 shadow-xs hover:bg-gray-50 hover:ring-gray-300 focus-visible:ring-4 focus-visible:ring-indigo-500/20',
    dark: 'text-white bg-gray-900 shadow-sm hover:bg-black focus-visible:ring-4 focus-visible:ring-gray-900/25',
    danger: 'text-white bg-red-600 shadow-sm hover:bg-red-500 focus-visible:ring-4 focus-visible:ring-red-500/30',
    warning: 'text-white bg-orange-600 shadow-sm hover:bg-orange-500 focus-visible:ring-4 focus-visible:ring-orange-500/30',
    soft: 'text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus-visible:ring-4 focus-visible:ring-indigo-500/20',
    ghost: 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus-visible:ring-4 focus-visible:ring-gray-500/15',
};
const SIZES = {
    xs: 'h-7 px-2.5 text-xs gap-1 rounded-md',
    sm: 'h-8 px-3 text-sm gap-1.5 rounded-lg',
    md: 'h-10 px-4 text-sm gap-2 rounded-lg',
    lg: 'h-11 px-5 text-[15px] gap-2 rounded-xl',
};

const classes = computed(() => [
    'relative inline-flex items-center justify-center font-semibold whitespace-nowrap select-none outline-none transition duration-150 ease-out',
    'disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none',
    VARIANTS[props.variant] ?? VARIANTS.primary,
    SIZES[props.size] ?? SIZES.md,
    props.block ? 'w-full' : '',
]);
</script>

<template>
    <component :is="href ? Link : 'button'"
               :href="href || undefined"
               :method="href ? method : undefined"
               :as="href ? as : undefined"
               :type="href ? undefined : type"
               :disabled="href ? undefined : (disabled || loading)"
               :class="classes">
        <span v-if="$slots.icon" class="inline-flex shrink-0 [&>svg]:w-[1.15em] [&>svg]:h-[1.15em]" :class="{'opacity-0': loading}">
            <slot name="icon"/>
        </span>
        <span v-if="$slots.default" class="inline-flex items-center" :class="{'hidden sm:inline-flex': hiddenTextOnSmallScreen, 'opacity-0': loading}">
            <slot/>
        </span>
        <span v-if="$slots.iconRight" class="inline-flex shrink-0" :class="{'opacity-0': loading}">
            <slot name="iconRight"/>
        </span>
        <span v-if="loading" class="absolute inset-0 flex items-center justify-center">
            <CircleLoadingIcon class="animate-spin w-5 h-5"/>
        </span>
    </component>
</template>
