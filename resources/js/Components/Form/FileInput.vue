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
    <div>
        <div class="flex items-center justify-between">
            <label :for="id" class="capitalize relative block mb-0.5 text-sm font-medium text-gray-900">
                {{ label }}
                <span v-if="required" class="text-red-600 absolute -top-1 -right-2.5">*</span>
            </label>
            <span v-if="errors" :class="$style['capitalize-first']" class="text-sm text-red-500">{{ errors }}</span>
        </div>
        <input :id="id" :accept="accept"
               :class="{'border border-red-700': errors}"
               :required="required" accept="image/png,jpg"
               class="w-full py-2 px-3 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
               type="file"/>
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
