<script setup>
// Legacy Mixpost API kept (type, size, isLoading, hiddenTextOnSmallScreen) — renders the design-system button.
import Button from "@/Components/UI/Button.vue";
defineProps({
    type: {type: String, default: 'button'},
    size: {type: String, default: 'md'},
    isLoading: {type: Boolean, default: false},
    hiddenTextOnSmallScreen: {type: Boolean, default: false},
});
</script>
<template>
    <Button variant="secondary" :type="type" :size="size === 'lg' ? 'md' : size" :loading="isLoading" :hidden-text-on-small-screen="hiddenTextOnSmallScreen">
        <template v-if="$slots.icon" #icon><slot name="icon"/></template>
        <slot/>
    </Button>
</template>
