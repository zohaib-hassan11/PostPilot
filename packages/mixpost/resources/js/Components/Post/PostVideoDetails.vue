<script setup>
/**
 * Post editor block: video metadata shared by every video platform (YouTube, TikTok, Reels…).
 * Writes into form.video_details; limits mirror Inovector\Mixpost\Support\VideoDetails (server is the authority).
 */
import {computed, ref} from "vue";
import Card from "@/Components/UI/Card.vue";
import Button from "@/Components/UI/Button.vue";
import FormField from "@/Components/UI/FormField.vue";
import TagInput from "@/Components/UI/TagInput.vue";
import Input from "@/Components/Form/Input.vue";
import Textarea from "@/Components/Form/Textarea.vue";
import AddMedia from "@/Components/Media/AddMedia.vue";
import PhotoIcon from "@/Icons/Photo.vue";
import VideoSolidIcon from "@/Icons/VideoSolid.vue";
import useNotifications from "@/Composables/useNotifications";

const LIMITS = {title: 100, description: 5000, tags: 30, tagsTotal: 500};
const PRIVACY = [
    {value: 'public', label: 'Public', hint: 'Anyone can find and watch it'},
    {value: 'unlisted', label: 'Unlisted', hint: 'Only people with the link'},
    {value: 'private', label: 'Private', hint: 'Only you'},
];

const props = defineProps({
    form: {type: Object, required: true},
    errors: {type: Object, default: () => ({})},   // {'video_details.title': 'message', …}
    disabled: {type: Boolean, default: false},
});

const {notify} = useNotifications();
const details = computed(() => props.form.video_details);
const open = ref(!!(details.value.title || details.value.description || details.value.tags.length || details.value.thumbnail));
const tagsTotal = computed(() => details.value.tags.reduce((n, t) => n + t.length, 0) + Math.max(0, details.value.tags.length - 1));
const err = (key) => props.errors[`video_details.${key}`] ?? null;

const pickThumbnail = (items) => {
    const image = (items || []).find(item => !item.is_video && !/gif$/i.test(item.mime_type || ''));
    if (!image) {
        notify('error', 'Please choose an image (JPG or PNG) for the thumbnail.');
        return;
    }
    details.value.thumbnail = image;
    details.value.thumbnail_media_id = image.id;
};
const removeThumbnail = () => {
    details.value.thumbnail = null;
    details.value.thumbnail_media_id = null;
};
</script>

<template>
    <Card class="mt-6">
        <template #title>
            <span class="inline-flex items-center gap-2">
                <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 [&>svg]:w-4 [&>svg]:h-4"><VideoSolidIcon/></span>
                Video details
            </span>
        </template>
        <template #description>Title, description, tags, thumbnail and privacy for video platforms like YouTube and TikTok.</template>
        <template #action>
            <Button variant="ghost" size="sm" @click="open = !open">{{ open ? 'Hide' : 'Add details' }}</Button>
        </template>

        <div v-if="open" class="@container">
        <div class="grid gap-6 @3xl:grid-cols-[1fr_300px]">
            <div class="space-y-5">
                <FormField label="Title" for="vd-title" :count="details.title.length" :max="LIMITS.title" :error="err('title')"
                           hint="The headline people see first. Keep it clear and specific.">
                    <Input id="vd-title" v-model="details.title" :disabled="disabled" :error="!!err('title')" placeholder="e.g. How AI books appointments while you sleep"/>
                </FormField>

                <FormField label="Description" for="vd-desc" :count="details.description.length" :max="LIMITS.description" :error="err('description')" optional>
                    <Textarea id="vd-desc" v-model="details.description" :disabled="disabled" :error="!!err('description')" rows="6"
                              placeholder="What the video is about, links, chapters…"/>
                </FormField>

                <FormField label="Tags" :count="tagsTotal" :max="LIMITS.tagsTotal" :error="err('tags')" optional
                           :hint="`Up to ${LIMITS.tags} tags. Press Enter or comma to add.`">
                    <TagInput v-model="details.tags" :max="LIMITS.tags" placeholder="automation, AI, small business"/>
                </FormField>

                <FormField label="Privacy" :error="err('privacy')">
                    <div class="grid @md:grid-cols-3 gap-2" role="radiogroup">
                        <button v-for="p in PRIVACY" :key="p.value" type="button" role="radio" :aria-checked="details.privacy === p.value"
                                :disabled="disabled" @click="details.privacy = p.value"
                                class="text-left rounded-xl px-3.5 py-2.5 ring-1 ring-inset transition"
                                :class="details.privacy === p.value ? 'bg-indigo-50 ring-indigo-400 shadow-sm' : 'bg-white ring-gray-200 hover:ring-gray-300'">
                            <div class="text-sm font-semibold" :class="details.privacy === p.value ? 'text-indigo-700' : 'text-gray-900'">{{ p.label }}</div>
                            <div class="text-xs text-gray-500">{{ p.hint }}</div>
                        </button>
                    </div>
                </FormField>
            </div>

            <FormField class="@3xl:order-none" label="Thumbnail" :error="err('thumbnail_media_id')" optional hint="1280×720 JPG or PNG works best on every platform.">
                <div class="relative aspect-video w-full overflow-hidden rounded-xl ring-1 ring-inset ring-gray-200 bg-gray-50">
                    <img v-if="details.thumbnail" :src="details.thumbnail.url" alt="Video thumbnail" class="w-full h-full object-cover"/>
                    <div v-else class="flex h-full flex-col items-center justify-center gap-1.5 text-gray-400">
                        <PhotoIcon class="w-7 h-7"/>
                        <span class="text-xs">No thumbnail yet</span>
                    </div>
                </div>
                <div class="mt-3 flex gap-2">
                    <AddMedia @insert="pickThumbnail">
                        <Button variant="secondary" size="sm" :disabled="disabled">
                            <template #icon><PhotoIcon/></template>
                            {{ details.thumbnail ? 'Change' : 'Choose image' }}
                        </Button>
                    </AddMedia>
                    <Button v-if="details.thumbnail" variant="ghost" size="sm" :disabled="disabled" @click="removeThumbnail">Remove</Button>
                </div>
            </FormField>
        </div>
        </div>
    </Card>
</template>
