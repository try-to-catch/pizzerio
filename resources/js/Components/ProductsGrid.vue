<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";
import FilterIcon from "@/Components/Icons/FilterIcon.vue";
import {ICategoryEssentialsWithProductCards} from "@/types/ICategoryEssentialsWithProductCards";
import {IProductCardEssentials} from "@/types/IProductCardEssentials";

const {category} = defineProps<{ category: ICategoryEssentialsWithProductCards }>()


const emit = defineEmits<{ (e: 'productChosen', value: IProductCardEssentials): void }>()

const notifyBaseComponent = (product: IProductCardEssentials) => {
    emit('productChosen', product)
}
</script>

<template>
    <div>
        <div class="flex justify-between sm:mb-8 mb-5 items-center">
            <h3 class="sm:text-[40px] sm:leading-[48px] text-[28px] leading-[32px] font-semibold">
                <Link :href="route('categories.show', {category: category.slug})">
                    {{ category.title }}
                </Link>
            </h3>
            <div class="py-[9px] px-4 bg-white flex items-center rounded-md border border-gray-100 text-sm sm:text-base" role="button">
                <filter-icon class="mr-2 h-4 w-4"/>
                Фильтры
            </div>
        </div>

        <div class="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 sm:gap-[30px] gap-3">
            <ProductCard v-for="product in category.products" :key="product.id"
                         :product="product" @click="notifyBaseComponent(product)"/>
        </div>
    </div>
</template>
