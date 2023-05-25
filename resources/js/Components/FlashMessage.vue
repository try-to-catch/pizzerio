<script lang="ts" setup>
import {onMounted, ref} from "vue";

const {message} = defineProps<{ message?: string }>()

const isMessageVisible = ref(true)

onMounted(() => {
    setTimeout(() => isMessageVisible.value = false, 10000)
})

const hiddeMessage = () => isMessageVisible.value = false
</script>

<template>
    <transition name="flash-message">
        <div v-if="isMessageVisible && message" class="absolute top-2 w-full flex justify-center"
             @click="hiddeMessage">
            <div class="min-w-[240px] bg-gray-400 shadow-xl text-white h-12  py-3 px-5 rounded-md text-center">
                {{ message }}
            </div>
        </div>
    </transition>
</template>

<style scoped>
.flash-message-enter-active,
.flash-message-leave-active {
    opacity: 1;
    transition: opacity 0.3s ease-in-out;
}

.flash-message-enter-from,
.flash-message-leave-to {
    opacity: 0;
}
</style>
