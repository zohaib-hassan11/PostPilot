<script setup>
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";
import Alert from "@/Components/UI/Alert.vue";
import Button from "@/Components/UI/Button.vue";
import PrimaryButton from "../Button/PrimaryButton.vue";

const props = defineProps({
    isConfigured: {
        type: Object,
        required: true,
    }
})

const any = computed(() => {
    return Object.keys(props.isConfigured).some((service) => {
        return !['tenor', 'unsplash'].includes(service) && props.isConfigured[service] !== true
    })
});
</script>
<template>
    <div v-if="any" class="mb-6">
        <Alert variant="warning" title="Finish setting up your services">
            <p v-if="!isConfigured.facebook">Facebook service is not configured yet.</p>
            <p v-if="!isConfigured.twitter">X (Twitter) service is not configured yet.</p>
            <template #actions>
                <Button size="sm" :href="route('mixpost.services.index')">Configure services</Button>
            </template>
        </Alert>
    </div>
</template>
