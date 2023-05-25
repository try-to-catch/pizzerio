<script lang="ts" setup>
withDefaults(defineProps<{
    required?: boolean,
    errors?: string,
    id?: string,
    rows?: string,
    label?: string,
    modelValue?: string
}>(), {id: 'icon', label: 'Icon', required: false, rows: '3'})
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
        <textarea :id="id" :class="{'border border-red-700': errors }" :required="required"
                  :rows="rows" :value="modelValue"
                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
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
