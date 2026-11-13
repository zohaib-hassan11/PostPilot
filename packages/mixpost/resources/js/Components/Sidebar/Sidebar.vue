<script setup>
import {Link} from '@inertiajs/vue3';
import Logo from "@/Components/DataDisplay/Logo.vue"
import MenuItem from "@/Components/Sidebar/MenuItem.vue"
import MenuDelimiter from "@/Components/Sidebar/MenuDelimiter.vue"
import MenuGroupHeader from "@/Components/Sidebar/MenuGroupHeader.vue"
import MenuGroupBody from "@/Components/Sidebar/MenuGroupBody.vue"
import PlusIcon from "@/Icons/Plus.vue"
import GridIcon from "@/Icons/Grid.vue"
import CalendarIcon from "@/Icons/Calendar.vue"
import PhotoIcon from "@/Icons/Photo.vue"
import ShareIcon from "@/Icons/Share.vue"
import CogIcon from "@/Icons/Cog.vue"
import ServerStackIcon from "@/Icons/ServerStack.vue"
import UserMenu from "../Navigation/UserMenu.vue";
import QueueList from "../../Icons/QueueList.vue";
import InformationCircle from "../../Icons/InformationCircle.vue";
import Document from "../../Icons/Document.vue";
</script>
<template>
    <div class="relative w-full h-full flex flex-col py-xl bg-[#0b0b10] text-white border-r border-white/5 overflow-hidden">
        <!-- soft purple glow behind the brand -->
        <div class="pointer-events-none absolute -top-24 -left-16 w-72 h-72 rounded-full bg-indigo-500/25 blur-3xl"></div>
        <div class="relative mb-10 px-xl">
            <Link :href="route('mixpost.dashboard')">
                <Logo variant="dark"/>
            </Link>
        </div>

        <div class="relative flex px-xl">
            <Link :href="route('mixpost.posts.create')"
                  class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-md py-3 font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-700 shadow-lg shadow-indigo-900/40 hover:from-indigo-400 hover:to-indigo-600 transition">
                <PlusIcon class="w-5 h-5"/>
                Create post
            </Link>
        </div>

        <div class="relative flex flex-col space-y-md overflow-y-auto px-lg mt-2xl h-full">
            <MenuGroupBody>
                <MenuItem :url="route('mixpost.dashboard')" :active="$page.component === 'Dashboard'">
                    <template #icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                    </template>
                    Dashboard
                </MenuItem>
            </MenuGroupBody>
            <MenuDelimiter/>
            <MenuGroupHeader :create-url="route('mixpost.posts.create')" class="mt-lg">
                Content
                <template #icon>
                    <PlusIcon/>
                </template>
            </MenuGroupHeader>
            <MenuGroupBody>
                <MenuItem :url="route('mixpost.posts.index')"
                          :active="$page.component === 'Posts/Index'">
                    <template #icon>
                        <GridIcon/>
                    </template>
                    Posts
                </MenuItem>
                <MenuItem :url="route('mixpost.calendar')" :active="$page.component === 'Calendar'">
                    <template #icon>
                        <CalendarIcon/>
                    </template>
                    Calendar
                </MenuItem>
                <MenuItem :url="route('mixpost.media.index')" :active="$page.component === 'Media'">
                    <template #icon>
                        <PhotoIcon/>
                    </template>
                    Media Library
                </MenuItem>
            </MenuGroupBody>
            <MenuDelimiter/>
            <MenuGroupHeader :create-url="route('mixpost.posts.create')">
                Configuration
            </MenuGroupHeader>
            <MenuGroupBody>
                <MenuItem :url="route('mixpost.accounts.index')" :active="$page.component === 'Accounts/Accounts'">
                    <template #icon>
                        <ShareIcon/>
                    </template>
                    Social Accounts
                </MenuItem>
                <MenuItem :url="route('mixpost.services.index')" :active="$page.component === 'Services'">
                    <template #icon>
                        <ServerStackIcon/>
                    </template>
                    Services
                </MenuItem>
                <MenuItem :url="route('mixpost.settings.index')" :active="$page.component === 'Settings'">
                    <template #icon>
                        <CogIcon/>
                    </template>
                    Settings
                </MenuItem>
            </MenuGroupBody>
            <MenuDelimiter/>
            <MenuGroupHeader>
                System
            </MenuGroupHeader>
            <MenuGroupBody>
                <MenuItem :url="route('mixpost.system.status')" :active="$page.component === 'System/Status'">
                    <template #icon>
                        <InformationCircle/>
                    </template>
                    Status
                </MenuItem>
                <MenuItem :url="route('mixpost.system.logs.index')" :active="$page.component === 'System/Logs'">
                    <template #icon>
                        <Document/>
                    </template>
                    Logs
                </MenuItem>
                <template v-if="$page.props.app.horizon_path">
                    <MenuItem :url="`/${$page.props.app.horizon_path}`" :external="true" externalTarget="_blank">
                        <template #icon>
                            <QueueList/>
                        </template>
                        Laravel Horizon
                    </MenuItem>
                </template>
            </MenuGroupBody>
        </div>

        <div class="relative mx-lg mt-md p-sm rounded-xl bg-white/5 border border-white/10">
            <UserMenu/>
        </div>
    </div>
</template>
