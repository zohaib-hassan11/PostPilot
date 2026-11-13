<script setup>
/**
 * UI/Alert — inline message. <Alert variant="warning" title="Services not configured">Text… <template #actions><Button size="sm">Fix</Button></template></Alert>
 * variants: info | success | warning | error ; closeable
 */
import {ref} from "vue";
import CheckIcon from "@/Icons/Check.vue";
import ExclamationIcon from "@/Icons/Exclamation.vue";
import InformationCircleIcon from "@/Icons/InformationCircle.vue";
import XIcon from "@/Icons/X.vue";
const props = defineProps({
    variant: {type: String, default: 'info'},
    title: {type: String, default: null},
    closeable: {type: Boolean, default: false},
});
const show = ref(true);
const V = {
    info: {box: 'bg-indigo-50/70 ring-indigo-200 text-indigo-900', icon: 'bg-indigo-100 text-indigo-600', I: InformationCircleIcon},
    success: {box: 'bg-emerald-50/70 ring-emerald-200 text-emerald-900', icon: 'bg-emerald-100 text-emerald-600', I: CheckIcon},
    warning: {box: 'bg-amber-50/80 ring-amber-200 text-amber-900', icon: 'bg-amber-100 text-amber-600', I: ExclamationIcon},
    error: {box: 'bg-red-50/70 ring-red-200 text-red-900', icon: 'bg-red-100 text-red-600', I: ExclamationIcon},
};
const v = V[props.variant] ?? V.info;
</script>
<template>
    <div v-if="show" class="flex gap-3 rounded-2xl p-4 ring-1 ring-inset" :class="v.box">
        <span class="flex items-center justify-center w-9 h-9 shrink-0 rounded-xl [&>svg]:w-5 [&>svg]:h-5" :class="v.icon"><component :is="v.I"/></span>
        <div class="min-w-0 flex-1 text-sm leading-relaxed pt-1.5">
            <div v-if="title" class="font-semibold mb-0.5">{{ title }}</div>
            <div class="opacity-90"><slot/></div>
            <div v-if="$slots.actions" class="mt-3 flex flex-wrap gap-2"><slot name="actions"/></div>
        </div>
        <button v-if="closeable" @click="show = false" type="button" class="self-start p-1 rounded-lg opacity-60 hover:opacity-100 hover:bg-black/5"><XIcon class="w-4 h-4"/></button>
    </div>
</template>
