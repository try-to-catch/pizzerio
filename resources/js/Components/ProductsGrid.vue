<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";
import FilterIcon from "@/Components/Icons/FilterIcon.vue";
import {ICategoryEssentialsWithProductCards} from "@/types/ICategoryEssentialsWithProductCards";

const {category} = defineProps<{ category: ICategoryEssentialsWithProductCards }>()
</script>

<template>
    <div>
        <div class="flex justify-between mb-8 items-center">
            <h3 class="text-[40px] leading-[48px] font-semibold"><Link :href="route('products')">{{category.title}}</Link></h3>
            <div class="py-[9px] px-4 bg-white flex items-center rounded-md border border-gray-100" role="button">
                <filter-icon class="mr-2 h-4 w-4"/>
                Фильтры
            </div>
        </div>

        <div class="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-[30px]">
            <ProductCard v-for="product in category.products" :product="product"/>
        </div>
    </div>
</template>
