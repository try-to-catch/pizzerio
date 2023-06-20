<script lang="ts" setup>

import type {IProductCardEssentials} from "@/types/IProductCardEssentials";

const {product} = defineProps<{ product: IProductCardEssentials }>()
</script>

<template>
    <div class="rounded-xl bg-white relative border border-gray-100 cursor-pointer flex flex-row sm:flex-col h-[124px] sm:h-auto sm:max-h-full p-3 sm:p-0">
        <div v-if="product.banner"
             class="absolute sm:py-[7px] sm:px-[18px] px-2.5 py-1 sm:text-sm bg-red-bg text-white uppercase left-0 sm:top-5 top-2 rounded-r-md text-xs">
            {{ product.banner }}
        </div>
        <div class="overflow-hidden flex items-center justify-center sm:w-auto  w-[100px] shrink-0">
            <img class="sm:max-h-[300px] w-auto bg-cover" :alt="product.title" :src="product.thumbnail">
        </div>
        <div class="sm:m-5 sm:mt-4 ml-3 flex flex-col sm:justify-between justify-center grow">
            <h2 class="font-semibold capitalize text-sm sm:text-lg">{{ product.title }}</h2>
            <p class="sm:mt-3 mt-2 line-clamp-2 text-xs sm:text-base pb-2.5 sm:pb-0">{{ product.ingredients }}</p>
            <div class="sm:flex hidden justify-between items-center mt-4">
                <button class="text-white bg-primary py-[13px] px-8 rounded-md hover:bg-orange-600 ease-in-out duration-300">Выбрать</button>
                <span v-if="!product.sale_price" class="text-primary font-semibold text-lg">от {{ product.price }}$</span>
                <span v-else class="text-red-500 font-semibold text-lg ">от {{ product.sale_price }}$</span>
            </div>
            <div class="flex sm:hidden items-center text-sm">
                <div class="py-[7px] px-4 rounded-md bg-light-primary text-primary font-semibold">от {{ product.price }}$</div>
                <div v-if="product.sale_price" class="ml-3 text-gray-400 line-through">от {{ product.sale_price }}$</div>
            </div>
        </div>
    </div>
</template>
