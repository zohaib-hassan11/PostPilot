<script setup>
// Legacy Mixpost API kept (title prop, default slot = actions, description slot) — renders UI/PageHeader.
import PageHeader from "@/Components/UI/PageHeader.vue";
defineProps({title: {required: true, type: String}});
</script>
<template>
    <PageHeader :title="title">
        <template v-if="$slots.description" #description><slot name="description"/></template>
        <template v-if="$slots.default" #actions><slot/></template>
    </PageHeader>
</template>
