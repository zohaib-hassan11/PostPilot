<script setup>
// Legacy Mixpost API kept (href, size) — renders the design-system button as a link.
import Button from "@/Components/UI/Button.vue";
defineProps({
    href: {type: String, required: true},
    size: {type: String, default: 'md'},
});
</script>
<template>
    <Button variant="dark" :href="href" :size="size === 'lg' ? 'md' : size">
        <template v-if="$slots.icon" #icon><slot name="icon"/></template>
        <slot/>
    </Button>
</template>
