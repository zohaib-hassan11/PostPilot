<script setup>
defineProps({
    hoverable: {
        type: Boolean,
        default: false
    }
})
</script>
<template>
    <tr :class="{'bg-white hover:bg-indigo-50/40 transition-colors ease-in-out duration-150': hoverable}">
        <slot/>
    </tr>
</template>
