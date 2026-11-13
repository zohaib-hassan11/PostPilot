<script setup>
import {computed, inject, onMounted, ref, watch} from "vue";
import {Head, Link} from '@inertiajs/vue3';
import NProgress from 'nprogress'
import {find} from "lodash";
import useNotifications from "@/Composables/useNotifications";
import PageHeader from '@/Components/UI/PageHeader.vue';
import Button from '@/Components/UI/Button.vue';
import Card from '@/Components/UI/Card.vue';
import StatCard from '@/Components/UI/StatCard.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import CalendarIcon from '@/Icons/Calendar.vue';
import PaperAirplaneIcon from '@/Icons/PaperAirplane.vue';
import DocumentIcon from '@/Icons/Document.vue';
import ExclamationIcon from '@/Icons/Exclamation.vue';
import ShareIcon from '@/Icons/Share.vue';
import PlusIcon from '@/Icons/Plus.vue';
import PhotoIcon from '@/Icons/Photo.vue';
import ArrowRightIcon from '@/Icons/ArrowRight.vue';
import Account from "@/Components/Account/Account.vue"
import Tabs from "@/Components/Navigation/Tabs.vue"
import Tab from "@/Components/Navigation/Tab.vue"
import TwitterReports from "@/Components/Report/TwitterReports.vue"
import FacebookPageReports from "@/Components/Report/FacebookPageReports.vue"
import FacebookGroupReports from "@/Components/Report/FacebookGroupReports.vue"
import MastodonReports from "@/Components/Report/MastodonReports.vue"

const props = defineProps({
    accounts: {
        required: true,
        type: Array,
    },
    stats: {
        type: Object,
        default: () => ({scheduled: 0, published: 0, drafts: 0, failed: 0}),
    },
})

const greeting = (() => {
    const h = new Date().getHours();
    return h < 12 ? 'Good morning' : h < 18 ? 'Good afternoon' : 'Good evening';
})();
const today = new Date().toLocaleDateString(undefined, {weekday: 'long', day: 'numeric', month: 'long'});

const {notify} = useNotifications();
const appContext = inject('appContext');

const isLoading = ref(false);
const data = ref({
    metrics: {},
    audience: {}
});

const selectAccount = (account) => {
    appContext.dashboard_filter.account_id = account.id;
}

const isAccountSelected = (account) => {
    return appContext.dashboard_filter.account_id === account.id;
}

const selectPeriod = (value) => {
    appContext.dashboard_filter.period = value;
}

const isPeriodSelected = (value) => {
    return appContext.dashboard_filter.period === value;
}

const fetch = () => {
    isLoading.value = true;
    NProgress.start();

    axios.get(route('mixpost.reports'), {
        params: appContext.dashboard_filter
    }).then(function (response) {
        data.value = response.data;
    }).catch(() => {
        notify('error', 'Error retrieving analytics. Try again!');
    }).finally(() => {
        isLoading.value = false;
        NProgress.done();
    });
}

const providers = {
    'twitter': TwitterReports,
    'facebook_page': FacebookPageReports,
    'facebook_group': FacebookGroupReports,
    'mastodon': MastodonReports,
};

const component = computed(() => {
    const account = find(props.accounts, {id: appContext.dashboard_filter.account_id});

    if (account === undefined) {
        return;
    }

    return providers[account.provider];
});

onMounted(() => {
    if (!props.accounts.length) {
        return null;
    }

    if (!appContext.dashboard_filter.account_id) {
        selectAccount(props.accounts[0]);
        return null;
    }

    fetch();
})

watch(appContext.dashboard_filter, () => {
    fetch()
});
</script>
<template>
    <Head title="Dashboard"/>
    <div class="row-py">
        <PageHeader :title="`${greeting}, ${$page.props.auth?.user?.name ?? 'there'}`" :eyebrow="today">
            <template #description>Here's what's happening across your social channels.</template>
            <template #actions>
                <Button variant="secondary" :href="route('mixpost.calendar')">
                    <template #icon><CalendarIcon/></template>
                    Calendar
                </Button>
                <Button :href="route('mixpost.posts.create')">
                    <template #icon><PlusIcon/></template>
                    Create post
                </Button>
            </template>
        </PageHeader>

        <!-- KPIs -->
        <div class="row-px grid grid-cols-2 xl:grid-cols-4 gap-4">
            <StatCard label="Scheduled" :value="stats.scheduled" hint="Waiting to go out" tone="primary"><template #icon><CalendarIcon/></template></StatCard>
            <StatCard label="Published" :value="stats.published" hint="Live on your channels" tone="success"><template #icon><PaperAirplaneIcon/></template></StatCard>
            <StatCard label="Drafts" :value="stats.drafts" hint="Not scheduled yet" tone="neutral"><template #icon><DocumentIcon/></template></StatCard>
            <StatCard label="Failed" :value="stats.failed" hint="Need your attention" tone="warning"><template #icon><ExclamationIcon/></template></StatCard>
        </div>

        <!-- No accounts yet: guided onboarding -->
        <div v-if="!accounts.length" class="row-px mt-8">
            <Card padding="none">
                <EmptyState title="Connect your first social account"
                            description="Link your channels once. Then every post you create can go out to all of them, on schedule.">
                    <template #icon><ShareIcon/></template>
                    <template #actions>
                        <Button :href="route('mixpost.accounts.index')">
                            Connect accounts
                            <template #iconRight><ArrowRightIcon/></template>
                        </Button>
                        <Button variant="secondary" :href="route('mixpost.services.index')">Configure services</Button>
                    </template>
                </EmptyState>
                <div class="grid sm:grid-cols-3 border-t border-gray-100">
                    <div v-for="(step, i) in [
                            {t: 'Connect accounts', d: 'Facebook, X, Mastodon and more.'},
                            {t: 'Create a post', d: 'Write once, add media and a time.'},
                            {t: 'Publish everywhere', d: 'We post it to every channel for you.'}]"
                         :key="i" class="p-6 sm:[&:not(:last-child)]:border-r border-gray-100">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-7 h-7 rounded-full bg-indigo-50 text-indigo-700 text-sm font-bold">{{ i + 1 }}</span>
                            <span class="font-semibold text-gray-900">{{ step.t }}</span>
                        </div>
                        <p class="mt-2 pl-10 text-sm text-gray-500">{{ step.d }}</p>
                    </div>
                </div>
            </Card>
        </div>

        <!-- Analytics -->
        <div v-else class="row-px mt-8">
            <Card>
                <template #title>Performance</template>
                <template #description>Pick an account and a period to see its analytics.</template>
                <template #action>
                    <Tabs>
                        <Tab @click="selectPeriod('7_days')" :active="isPeriodSelected('7_days')">7 days</Tab>
                        <Tab @click="selectPeriod('30_days')" :active="isPeriodSelected('30_days')">30 days</Tab>
                        <Tab @click="selectPeriod('90_days')" :active="isPeriodSelected('90_days')">90 days</Tab>
                    </Tabs>
                </template>
                <div class="flex flex-wrap items-center gap-2">
                    <template v-for="account in accounts" :key="account.id">
                        <button @click="selectAccount(account)" type="button"
                                class="rounded-full p-0.5 transition"
                                :class="isAccountSelected(account) ? 'ring-2 ring-indigo-500' : 'ring-2 ring-transparent hover:ring-gray-200'">
                            <Account :provider="account.provider" :active="isAccountSelected(account)" :img-url="account.image" v-tooltip="account.name"/>
                        </button>
                    </template>
                </div>
            </Card>
            <component :is="component" :data="data" :isLoading="isLoading"/>
        </div>

        <!-- Quick actions -->
        <div class="row-px mt-8 grid sm:grid-cols-3 gap-4">
            <Link v-for="qa in [
                    {t: 'Create a post', d: 'Write, add media, schedule.', href: route('mixpost.posts.create'), icon: PlusIcon},
                    {t: 'Media library', d: 'Images and videos in one place.', href: route('mixpost.media.index'), icon: PhotoIcon},
                    {t: 'Content calendar', d: 'See everything that is planned.', href: route('mixpost.calendar'), icon: CalendarIcon}]"
                  :key="qa.t" :href="qa.href" class="group">
                <Card interactive padding="md">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center justify-center w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition [&>svg]:w-5 [&>svg]:h-5"><component :is="qa.icon"/></span>
                        <div class="min-w-0">
                            <div class="font-semibold text-gray-900">{{ qa.t }}</div>
                            <div class="text-sm text-gray-500 truncate">{{ qa.d }}</div>
                        </div>
                        <ArrowRightIcon class="ml-auto w-5 h-5 text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-0.5 transition"/>
                    </div>
                </Card>
            </Link>
        </div>
    </div>
</template>
