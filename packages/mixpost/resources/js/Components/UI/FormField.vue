<script setup>
/**
 * UI/FormField — label + control + hint/counter + error, the same everywhere.
 * <FormField label="Title" :count="form.title.length" :max="100" :error="errors.title" hint="Shown on YouTube"> <Input v-model="…"/> </FormField>
 */
defineProps({
    label: {type: String, required: true},
    for: {type: String, default: null},
    hint: {type: String, default: null},
    error: {type: String, default: null},
    count: {type: Number, default: null},
    max: {type: Number, default: null},
    optional: {type: Boolean, default: false},
});
</script>
<template>
    <div>
        <div class="flex items-baseline justify-between mb-1.5">
            <label :for="$props.for" class="text-sm font-medium text-gray-800">
                {{ label }} <span v-if="optional" class="font-normal text-gray-400">(optional)</span>
            </label>
            <span v-if="max !== null && count !== null" class="text-xs tabular-nums"
                  :class="count > max ? 'text-red-600 font-semibold' : count > max * 0.9 ? 'text-amber-600' : 'text-gray-400'">{{ count }}/{{ max }}</span>
        </div>
        <slot/>
        <p v-if="error" class="mt-1.5 text-sm text-red-600">{{ error }}</p>
        <p v-else-if="hint" class="mt-1.5 text-xs text-gray-500">{{ hint }}</p>
    </div>
</template>
