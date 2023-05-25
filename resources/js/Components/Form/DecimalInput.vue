<script lang="ts" setup>

interface InputFieldProps {
    label: string,
    id: string,
    errors?: string,
    step?: number,
    required?: boolean,
    modelValue?: number | string
}

withDefaults(defineProps<InputFieldProps>(), {step: 0.01, required: false})

defineEmits<{ 'update:ModelValue': (value: string) => void }>()

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
        <input :id="id" :class="{'border border-red-700': errors }"
               :required="required"
               :step="step"
               :value="modelValue"
               min="0"
               class="rounded-md w-full" type="number" @input="$emit('update:modelValue', $event.target.value)"
        />
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
