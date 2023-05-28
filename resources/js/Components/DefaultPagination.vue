<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="cursor-pointer mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                     v-html="link.label"/>
                <Link v-else
                      :class="{
                    'bg-red-700 text-white': link.active,
                    'hover:bg-white focus:border-red-500 focus:text-red-500': !link.active
                       }"
                      :href="link.url"
                      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
                      v-html="link.label"/>
            </template>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";

defineProps<{ links: any }>()
</script>
