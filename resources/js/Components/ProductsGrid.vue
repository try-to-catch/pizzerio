<script lang="ts" setup>

import ProductCard from "@/Components/ProductCard.vue";
import FilterIcon from "@/Components/Icons/FilterIcon.vue";
</script>

<template>
    <div>
        <div class="flex justify-between mb-8 items-center">
            <h3 class="text-[40px] leading-[48px] font-semibold">Пицца</h3>
            <div class="py-[9px] px-4 bg-white flex items-center rounded-md border border-gray-100" role="button">
                <filter-icon class="mr-2 h-4 w-4"/>
                Фильтры
            </div>
        </div>

        <div class="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-[30px]">
            <ProductCard v-for="i in 9" :product="{
                    id: 1,
                    title: 'Чикен Сладкий Чили',
                    description: 'Курица, Лук, Перец Халапеньо, Сыр Моцарелла, Томатный соус, Паприка, Майонез',
                    price: 4.5,
                    thumbnail: '/images/nice-pizza.png',
                    status: 'Hot'}"/>
        </div>
    </div>
</template>
