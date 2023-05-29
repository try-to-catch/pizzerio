<template>
    <font-awesome-icon v-if="isSuccess" :icon="faCircleCheck" class="text-green-500"
                       size="lg"/>
    <font-awesome-icon v-else :icon="faCircleXmark" class="text-red-500"
                       size="lg"/>
</template>

<script lang="ts" setup>
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faCircleCheck, faCircleXmark} from "@fortawesome/free-solid-svg-icons";

withDefaults(defineProps<{ isSuccess: boolean, size: string }>(), {size: 'lg'})
</script>
