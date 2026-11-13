<script setup>
import EditorButton from "../Button/EditorButton.vue";
import ProLabel from "./ProLabel.vue";
import UpgradePro from "./UpgradePro.vue";

defineProps({
    tooltip: {
        type: String,
        required: true
    },
    showLabelHover: {
        type: Boolean,
        default: true
    }
});
</script>
<template>
    <!-- Mixpost "Pro" upsell removed for this product -->
    <span v-if="false"></span>
</template>
