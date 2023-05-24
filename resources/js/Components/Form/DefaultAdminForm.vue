<template>
    <form class="relative overflow-x-auto shadow-md sm:rounded-b-lg px-5 py-3 space-y-4 bg-white">
        <slot></slot>
    </form>
</template>

<script lang="ts">
export default {
    name: "DefaultAdminForm"
}
</script>
