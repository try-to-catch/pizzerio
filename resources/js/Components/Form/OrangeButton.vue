<template>
    <button class="pt-2.5 pb-1.5 px-4 text-white rounded-md w-full bg-orange-400 enabled:hover:bg-orange-500 ease-in-out duration-300 disabled:opacity-75" :type="type">
        <slot/>
    </button>
</template>

<script lang="ts">

export default {
    name: "OrangeButton",
    props: {
        type: {
            type: String,
            default: 'submit'
        },
    }
}
</script>
