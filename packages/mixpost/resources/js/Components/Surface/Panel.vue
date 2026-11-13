<script setup>
// Legacy Mixpost API kept (withPadding + title/description/action slots) — renders UI/Card.
import Card from "@/Components/UI/Card.vue";
defineProps({withPadding: {type: Boolean, default: true}});
</script>
<template>
    <Card :padding="withPadding ? 'lg' : 'none'">
        <template v-if="$slots.title" #title><slot name="title"/></template>
        <template v-if="$slots.description" #description><slot name="description"/></template>
        <template v-if="$slots.action" #action><slot name="action"/></template>
        <slot/>
    </Card>
</template>
