<script setup>
import LockClosed from "../../Icons/LockClosed.vue";
import LockOpen from "../../Icons/LockOpen.vue";

defineProps({
    withTitle: {
        type: Boolean,
        default: true
    },
    paddingClass: {
        type: String,
        default: 'py-[1px] px-1'
    },
    name: {
        type: String,
        default: 'Pro'
    },
    icon: {
        type: String,
        default: 'lock-closed'
    }
})
</script>
<template>
    <!-- Mixpost "Pro" upsell removed for this product -->
    <span v-if="false"></span>
</template>
