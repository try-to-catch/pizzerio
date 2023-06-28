<script lang="ts" setup>
withDefaults(defineProps<{
    required?: boolean,
    errors?: string,
    id?: string,
    rows?: string,
    label?: string,
    modelValue?: string,
    placeholder?: string,
}>(), {id: 'icon', label: '', required: false, rows: '3'})
</script>

<template>
    <div class="w-full">
        <div class="flex items-center justify-between">
            <label :for="id" class="capitalize relative block mb-0.5 text-sm font-medium text-gray-900">
                {{ label }}{{ required ? '*' : '' }}
            </label>
            <span v-if="errors" :class="$style['capitalize-first']" class="text-sm text-red-500">{{ errors }}</span>
        </div>
        <textarea :id="id" :class="{'border border-red-700': errors }" :required="required"
                  :rows="rows" :value="modelValue" :placeholder="placeholder"
                  class="placeholder:text-gray-text block px-4 pt-[13px] w-full sm:text-base text-sm text-black-text rounded-md border border-gray-border focus:ring-transparent focus:border-primary resize-none"
                  @input="$emit('update:modelValue', $event.target.value)"></textarea>
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
