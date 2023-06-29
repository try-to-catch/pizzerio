<script lang="ts" setup>
const FLOUR = 0
const CEIL = 100

const props = defineProps<{ modelValue: number }>()
const emit = defineEmits<{ (e: 'update:modelValue', value: IProductQuantityValues): void }>()
const stepValue = (stepForward: boolean) => {
    const values = {
        old: props.modelValue,
        new: stepForward ? props.modelValue + 1 : props.modelValue - 1
    }

    if (values.new > FLOUR && values.new < CEIL) {
        emit('update:modelValue', values)
    }
}

const setValue = (value: number) => {
    const values = {
        old: props.modelValue,
        new: value
    }

    if (value > FLOUR && value < CEIL) {
        emit('update:modelValue', values)
    }
}
</script>

<template>
    <div class="w-[92px] md:h-9 h-8 bg-light-primary flex justify-center items-center rounded-md">
        <span class="text-primary pr-1.5 pl-2 md:py-1.5 py-1 cursor-pointer select-none"
              @click="stepValue(false)">-</span>

        <input :class="$style['input-arrows']"
               :max="CEIL"
               :min="FLOUR" :value="modelValue"
               class="p-0 text-primary bg-light-primary h-5 w-10 text-center border-none outline-none ring-offset-[0px!important] text-sm sm:text-base"
               type="number"
               @input="setValue(Number($event.target.value))"
        >

        <span class="text-primary pr-2 pl-1.5 md:py-1.5 py-1 cursor-pointer select-none"
              @click="stepValue(true)">+</span>
    </div>
</template>


<style module>
.input-arrows::-webkit-outer-spin-button,
.input-arrows::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    display: none;
}
</style>
