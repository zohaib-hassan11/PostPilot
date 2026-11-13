<script setup>
// Legacy Mixpost API kept (variant) — renders UI/Badge.
import Badge from "@/Components/UI/Badge.vue";
defineProps({variant: {type: String, default: 'neutral'}});
</script>
<template>
    <Badge :variant="variant"><slot/></Badge>
</template>
