<script lang="ts" setup>
withDefaults(defineProps<{
    required?: boolean,
    type?: string,
    placeholder?: string,
    label?: string,
    modelValue?: string
}>(), {
    required: false,
    type: 'text',
    label: '',
})


defineEmits<{ 'update:ModelValue': (value: string) => void }>()
</script>

<template>
    <label class="text-sm font-medium text-gray-text sm:text-xs">
        {{ label }}{{ required ? '*' : '' }}
        <input :placeholder="placeholder" :required="required"
               :type="type"
               :value="modelValue"
               class="mt-2 border border-gray-border text-gray-black-text text-sm rounded-lg focus:ring-transparent focus:border-orange-500 block w-full py-[13px] px-4 placeholder:text-gray-text" @input="$emit('update:modelValue', $event.target.value)">
    </label>
</template>

