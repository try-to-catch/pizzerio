<script lang="ts" setup>
import type {IOrderEssentialsWithQuantity} from "@/types/IOrderEssentialsWithQuantity";
import NumericInput from "@/Components/Form/NumericInput.vue";
import CrossIcon from "@/Components/Icons/CrossIcon.vue";

const {products} = defineProps<{ products: IOrderEssentialsWithQuantity[] }>()
const emit = defineEmits<{
    (e: 'update:products', value: IOrderEssentialsWithQuantity[]): void,
    (e: 'removeItem', value: number): void,
    (e: 'updateItem', value: { id: number, quantity: number }): void,

}>()

const updateCartItem = (id: number, quantity) => {
    emit('updateItem', {id, quantity})
}

</script>

<template>
    <ul class="sm:space-y-4 space-y-3">
        <li v-for="product in products"
            class="rounded-xl bg-white p-4 pr-6 flex items-center w-full relative border border-gray-border">
            <div class="mr-4 sm:w-[120px] w-[85px] sm:h-[120px] h-[85px] ">
                <img :alt="product.title" :src="product.thumbnail">
            </div>
            <div class="flex flex-col md:flex-row md:items-center justify-between grow">
                <div class="">
                    <h4 class="sm:text-xl font-semibold flex items-center capitalize text-sm">
                        {{ product.title }}
                    </h4>
                    <p class="text-black-text mt-2 text-xs sm:text-base">Традиционное тесто, 23 см</p>
                </div>
                <div class="flex mt-2 md:mt-0 justify-between">
                    <numeric-input v-model="product.quantity" class="mr-10 items-center"
                                   @update:modelValue="updateCartItem(product.id, $event)"
                    />
                    <div class="sm:text-xl font-semibold text-primary flex items-center text-sm">
                        {{ product.sale_price || product.price }} $
                    </div>
                </div>
            </div>

            <cross-icon class="absolute top-2.5 right-2.5 sm:w-4 sm:h-4 w-3 h-3 cursor-pointer"
                        fill="#A5A5A5" @click="emit('removeItem', product.id)"/>
        </li>
    </ul>
</template>
