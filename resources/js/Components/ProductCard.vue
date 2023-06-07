<script lang="ts" setup>

import type {IProductCardEssentials} from "@/types/IProductCardEssentials";

const {product} = defineProps<{ product: IProductCardEssentials }>()
</script>

<template>
    <div class="rounded-xl bg-white relative border border-gray-100">
        <div v-if="product.banner"
             class="absolute py-[7px] px-[18px] text-sm bg-red-bg text-white uppercase left-0 top-5 rounded-r-md">
            {{ product.banner }}
        </div>
        <div class="max:h-300 max:w-300 overflow-hidden flex items-center justify-center">
            <img :alt="product.title" :src="product.thumbnail">
        </div>
        <div class="m-5 mt-4">
            <h2 class="font-semibold capitalize">{{ product.title }}</h2>
            <p class="mt-3  line-clamp-2">{{ product.ingredients }}</p>
            <div class="flex justify-between items-center mt-4">
                <button class="text-white bg-primary py-[13px] px-8 rounded-md">Выбрать</button>
                <span v-if="!product.sale_price" class="text-primary font-semibold text-lg">от {{ product.price }}$</span>
                <span v-else class="text-red font-semibold text-lg ">от {{ product.sale_price }}$</span>
            </div>
        </div>
    </div>
</template>
