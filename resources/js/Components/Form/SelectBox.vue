<script lang="ts" setup>
interface InputFieldProps {
    options: { label: string, value: string | number }[],
    label: string,
    startOptionLabel: string,
    id: string,
    errors?: string,
    required?: boolean,
    modelValue?: number | string
}

withDefaults(defineProps<InputFieldProps>(), {required: false})

defineEmits<{ 'update:ModelValue': (value: number | string) => void }>()

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
        <select :id="id" :class="{'border border-red-700': errors }"
                :required="required"
                :value="modelValue"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                @change="$emit('update:modelValue', $event.target.value)">
            <option disabled selected>{{ startOptionLabel }}</option>
            <option v-for="option in options" :key="option.value"
                    :value="option.value">{{ option.label }}
            </option>
        </select>
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
