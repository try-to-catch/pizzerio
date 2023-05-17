<script lang="ts" setup>

import {computed} from "vue";

const props = defineProps<{ isSideNavOpen: boolean, label: string, shortLabel: string, url?: string }>()

const formattedLabel = computed(() => {
    return props.isSideNavOpen ? props.label : props.shortLabel
})
</script>

<template>
    <div :class="{
        'flex-col space-y-1 justify-center': !isSideNavOpen,
        'space-x-4': isSideNavOpen,
        'bg-gray-200': $page.url.startsWith(url || '~')
    }" class="w-full h-full flex items-center hover:bg-gray-200 py-2 px-4 rounded-md cursor-pointer">
        <slot class="w-5 h-5" name="icon"/>
        <span :class="{'text-[11px]': !isSideNavOpen}" class=" ">{{ formattedLabel }}</span>
    </div>
</template>
