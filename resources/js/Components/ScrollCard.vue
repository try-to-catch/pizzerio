<script lang="ts" setup>

const {image, caption} = defineProps<{
    image: string,
    caption: string
}>()
</script>


<template>
    <div :style="{ backgroundImage: `url(${image})` }"
         class="rounded-xl bg-cover bg-no-repeat bg-center  relative">
        <span class="absolute text-xl font-semibold bottom-5 left-5 lg:right-10 right-5 text-white">{{ caption }}</span>
    </div>
</template>
