<template>
    <div class="flex flex-col overflow-hidden rounded-2xl bg-white ring-1 ring-gray-200/70 shadow-[0_1px_2px_rgba(16,16,32,.04)]">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <table class="min-w-full divide-y divide-gray-100 border-collapse">
                    <thead v-if="$slots.head" class="bg-gray-50/80">
                    <slot name="head"/>
                    </thead>
                    <tbody v-if="$slots.body" class="divide-y divide-gray-100">
                    <slot name="body"/>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
