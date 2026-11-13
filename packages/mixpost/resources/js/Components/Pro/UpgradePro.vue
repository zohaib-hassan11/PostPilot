<script setup>
import {ref} from "vue";
import DialogModal from "../Modal/DialogModal.vue";
import LockOpen from "../../Icons/LockOpen.vue";
import Flex from "../Layout/Flex.vue";
import MenuDelimiter from "../Sidebar/MenuDelimiter.vue";
import Check from "../../Icons/Check.vue";
import QuestionMarkCircle from "../../Icons/QuestionMarkCircle.vue";
import PureButton from "../Button/PureButton.vue";
import ProLabel from "./ProLabel.vue";
import UnlockButton from "./UnlockButton.vue";

const show = ref(false);

const open = () => {
    show.value = true;
}

const close = () => {
    show.value = false;
}

const features = [
    {
        name: 'Publishing on Instagram, LinkedIn, Pinterest, TikTok and YouTube',
        desc: '',
    },
    {
        name: 'Workspaces',
        desc: 'Manage several brands, and businesses by organizing the social accounts, members, posts, and assets into dedicated spaces.',
    },
    {
        name: 'AI Assistant',
        desc: 'AI Assistant transforms how you manage social media by offering smart suggestions and providing insights to optimize your posts for maximum engagement.',
    },
    {
        name: 'Queue',
        desc: 'Build the habit of creating content for your audience and make your posting times more natural and less robotic.',
    },
    {
        name: 'Variables',
        desc: 'Insert variable text into your posts at the time of publication by using dynamic and custom variables.',
    },
    {
        name: 'Hashtag groups',
        desc: 'Enhance your social media strategy with organized hashtag groups.',
    },
    {
        name: 'Post templates',
        desc: 'Maximizing efficiency with reusable post templates.',
    },
    {
        name: 'Multilingual',
        desc: 'Manage operations in your language. Quickly switch between languages.',
    },
    {
        name: 'Post first comment/Thread',
        desc: 'Automatically add impactful first comments to your posts to boost engagement and extend conversations.',
    },
    {
        name: 'Post Activity',
        desc: 'Track each post&rsquo;s history and engage with team members through comments and reactions to streamline collaboration and feedback.',
    },
    {
        name: 'Approval flow',
        desc: "Review and approve posts before publishing to uphold quality and brand alignment across your team's content.",
    },
    {
        name: 'Webhooks',
        desc: 'A powerful feature designed to enhance your workflow by enabling real-time communication between Mixpost and your favorite external services.',
    },
    {
        name: 'API',
        desc: 'An advanced feature that opens up a world of possibilities by allowing third-party services to seamlessly communicate with your Mixpost instance.',
    },
    {
        name: 'White Label Logo',
        desc: 'Customize your branding by easily updating the logo to match your identity.',
    }
];
</script>
<template>
    <!-- Mixpost "Pro" upsell removed for this product -->
    <span v-if="false"></span>
</template>
