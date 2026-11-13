<script setup>
/**
 * UI/TagInput — type and press Enter or comma to add; Backspace on empty removes the last tag.
 * <TagInput v-model="tags" placeholder="Add a tag" :max="30"/>
 */
import {ref} from "vue";
import XIcon from "@/Icons/X.vue";
const props = defineProps({
    modelValue: {type: Array, default: () => []},
    placeholder: {type: String, default: 'Add a tag and press Enter'},
    max: {type: Number, default: null},
});
const emit = defineEmits(['update:modelValue']);
const draft = ref('');
const add = () => {
    const value = draft.value.replace(/^#+/, '').trim();
    draft.value = '';
    if (!value) return;
    if (props.max !== null && props.modelValue.length >= props.max) return;
    if (props.modelValue.some(t => t.toLowerCase() === value.toLowerCase())) return;
    emit('update:modelValue', [...props.modelValue, value]);
};
const remove = (i) => emit('update:modelValue', props.modelValue.filter((_, k) => k !== i));
const onKeydown = (e) => {
    if (e.key === 'Enter' || e.key === ',') { e.preventDefault(); add(); }
    else if (e.key === 'Backspace' && !draft.value && props.modelValue.length) { remove(props.modelValue.length - 1); }
};
</script>
<template>
    <div class="flex flex-wrap items-center gap-1.5 w-full min-h-[42px] rounded-lg border border-gray-200 bg-white px-2 py-1.5 shadow-xs focus-within:border-indigo-400 focus-within:ring-4 focus-within:ring-indigo-500/15 transition">
        <span v-for="(tag, i) in modelValue" :key="tag + i"
              class="inline-flex items-center gap-1 rounded-md bg-indigo-50 pl-2 pr-1 py-0.5 text-sm font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200">
            {{ tag }}
            <button type="button" @click="remove(i)" class="rounded p-0.5 hover:bg-indigo-100" :aria-label="`Remove ${tag}`"><XIcon class="w-3.5 h-3.5"/></button>
        </span>
        <input v-model="draft" @keydown="onKeydown" @blur="add" type="text" :placeholder="modelValue.length ? '' : placeholder"
               class="flex-1 min-w-[8rem] border-0 bg-transparent p-1 text-sm focus:ring-0 outline-none placeholder:text-gray-400"/>
    </div>
</template>
