<script setup>
// Legacy Mixpost API kept (variant, closeable) — renders UI/Alert.
import Alert from "@/Components/UI/Alert.vue";
defineProps({variant: {type: String, default: 'info'}, closeable: {type: Boolean, default: true}});
</script>
<template>
    <Alert :variant="variant" :closeable="closeable"><slot/></Alert>
</template>
