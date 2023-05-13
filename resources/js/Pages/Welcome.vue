<script lang="ts" setup>
import {Head, Link} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import ProductsGrid from "@/Components/ProductsGrid.vue";
import FlameIcon from "@/Components/Icons/FlameIcon.vue";
import PizzaIcon from "@/Components/Icons/PizzaIcon.vue";
import SushiIcon from "@/Components/Icons/SushiIcon.vue";
import DrinkIcon from "@/Components/Icons/DrinkIcon.vue";
import SnacksIcon from "@/Components/Icons/SnacksIcon.vue";
import ComboIcon from "@/Components/Icons/ComboIcon.vue";
import DessertsIcon from "@/Components/Icons/DessertsIcon.vue";
import SauceIcon from "@/Components/Icons/SauceIcon.vue";
</script>

<template>
    <Head><title>Home</title></Head>

    <main-layout>
        <div class="bg-gray-bg">
            <div class="lg:py-6 py-[14px] sm:mx-auto sm:container mx-5">
                <ul class="lg:space-x-[30px] space-x-3 flex overflow-auto py-[6px]" :class="[$style['scrollbar-thin']]" >
                    <li>
                        <a class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-[135px] lg:h-[104px] h-10 bg-white text-red-bg rounded-xl lg:text-lg text-sm"
                           href="#">
                            <flame-icon class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0"/>
                            Акции
                        </a>

                    </li>
                    <li>
                        <Link class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-[135px] lg:h-[104px] h-10 bg-white rounded-xl lg:text-lg text-sm"
                           :href="route('products')">
                            <pizza-icon class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0"/>
                            Пицца
                        </Link>
                    </li>
                    <li>
                        <a class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-[135px] lg:h-[104px] h-10 bg-white rounded-xl lg:text-lg text-sm"
                           href="#">
                            <sushi-icon class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0"/>
                            Суши
                        </a>
                    </li>
                    <li>
                        <a class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-[135px] lg:h-[104px] h-10 bg-white rounded-xl lg:text-lg text-sm"
                           href="#">
                            <drink-icon class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0"/>
                            Напитки
                        </a>
                    </li>
                    <li>
                        <a class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-[135px] lg:h-[104px] h-10 bg-white rounded-xl lg:text-lg text-sm"
                           href="#">
                            <snacks-icon class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0"/>
                            Закуски
                        </a>
                    </li>
                    <li>
                        <a class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-[135px] lg:h-[104px] h-10 bg-white rounded-xl lg:text-lg text-sm"
                           href="#">
                            <combo-icon class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0"/>
                            Комбо
                        </a>
                    </li>
                    <li>
                        <a class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-[135px] lg:h-[104px] h-10 bg-white rounded-xl lg:text-lg text-sm"
                           href="#">
                            <desserts-icon class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0"/>
                            Десерты
                        </a>
                    </li>
                    <li>
                        <a class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-[135px] lg:h-[104px] h-10 bg-white rounded-xl lg:text-lg text-sm"
                           href="#">
                            <sauce-icon class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0"/>
                            Соусы
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bg-gray-350">
                <div class="sm:container sm:mx-auto mx-5">
                    <products-grid class="py-[30px]"/>
                </div>
            </div>
        </div>
    </main-layout>
</template>

<style module>
@media only screen and (min-width: 768px) {
    .scrollbar-thin::-webkit-scrollbar {
        height: 7px;
    }

    /* Track */
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    /* Handle */
    .scrollbar-thin::-webkit-scrollbar-thumb {
        border-radius: 10px;
        @apply bg-primary;
    }

    /* Handle on hover */
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        @apply bg-orange-600;
    }
}

</style>
