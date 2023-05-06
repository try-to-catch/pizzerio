<script lang="ts" setup>

import LocationIcon from "@/Components/Icons/LocationIcon.vue";
import PersonIcon from "@/Components/Icons/PersonIcon.vue";
import PizzaIcon from "@/Components/Icons/PizzaIcon.vue";
import CartIcon from "@/Components/Icons/CartIcon.vue";
</script>

<template>
    <div class="font-sans-serif">
        <div>
            <div class="bg-white">
                <div class="h-10 flex justify-between container mx-auto">
                    <div class="space-x-10 flex items-center text-sm">
                        <div class="flex items-center">
                            <location-icon/>
                            <select class="border-none focus:outline-none text-sm py-0 pl-2">
                                <option selected value="London">Лондон</option>
                            </select>
                        </div>
                        <div>
                            <a class="hover:underline" href="#" @click.prevent>
                                Проверить адрес
                            </a>
                        </div>
                        <div>
                            Среднее время доставки*:
                            <span class="font-semibold">00:24:19</span>
                        </div>
                    </div>

                    <div class="space-x-10 text-sm flex items-center">
                        <div>Время работы: с 11:00 до 23:00</div>
                        <div class="">
                            <a class="text-sm flex items-center" href="#" @click.prevent>
                                <person-icon/>
                                <span class="hover:underline ml-2">
                        Войти в аккаунт
                        </span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="border-y border-gray-200 bg-white">
                <div class="h-16 flex items-center container mx-auto justify-between">
                    <div class="flex items-center h-full">
                        <div class="flex">
                            <pizza-icon class="w-8 h-8"/>
                            <span class="ml-3 text-xl">Куда пицца</span>
                        </div>
                        <div class="flex ml-12 h-full">
                            <ul class="flex h-full">
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a class="h-full w-full flex items-center" href="#">Акции</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a class="h-full w-full flex items-center" href="#">Пицца</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a class="h-full w-full flex items-center" href="#">Суши</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a class="h-full w-full flex items-center" href="#">Напитки</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a class="h-full w-full flex items-center" href="#">Закуски</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a class="h-full w-full flex items-center" href="#">Комбо</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a class="h-full w-full flex items-center" href="#">Десерты</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a class="h-full w-full flex items-center" href="#">Соусы</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a class="h-full w-full flex items-center" href="#">Другое</a></li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <div class="bg-primary py-2 px-4 flex space-x-2 rounded-[4px] w-full cursor-pointer">
                            <cart-icon/>
                            <span class="text-white">
                                0 $
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div></div>
        <div></div>
    </div>
</template>
