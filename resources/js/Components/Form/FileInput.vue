<script lang="ts" setup>
withDefaults(defineProps<{
    required?: boolean,
    errors?: string,
    id?: string,
    label?: string
    accept?: string
}>(), {id: 'icon', label: 'Icon', required: false, accept: 'image/png'})
</script>
<template>
    <div class="flex flex-col ">
        <label :for="id">{{ label }}</label>
        <input :id="id" :accept="accept"
               :class="{'border border-red-700': errors}"
               :name="id"
               :required="required" accept="image/png,jpg"
               class="py-2 px-3 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
               type="file"/>
        <span v-if="errors" :class="[$style['capitalize-first']]" class="text-sm text-red-500">{{ errors }}</span>
    </div>
</template>

<style module>
.capitalize-first {
    text-transform: lowercase;
}

.capitalize-first:first-letter {
    text-transform: uppercase;
}
</style>
