<script lang="ts" setup>

import LocationIcon from "@/Components/Icons/LocationIcon.vue";
import PersonIcon from "@/Components/Icons/PersonIcon.vue";
import PizzaIcon from "@/Components/Icons/PizzaIcon.vue";
import CartIcon from "@/Components/Icons/CartIcon.vue";
import PhoneIcon from "@/Components/Icons/PhoneIcon.vue";
import FacebookIcon from "@/Components/Icons/FacebookIcon.vue";
import InstaIcon from "@/Components/Icons/InstaIcon.vue";
import MenuIcon from "@/Components/Icons/MenuIcon.vue";
</script>

<template>
    <div class="font-sans-serif w-full min-h-[100vh] flex flex-col justify-between">
        <header>
            <div class="bg-white">
                <div class="h-10 flex justify-between sm:container sm:mx-auto mx-4">
                    <div class="space-x-10 flex items-center text-sm justify-between lg:justify-start lg:w-auto w-full">
                        <div class="flex items-center">
                            <location-icon/>
                            <select class="border-none focus:outline-none text-sm py-0 pl-2">
                                <option selected value="London">Лондон</option>
                            </select>
                        </div>
                        <div class="md:block hidden">
                            <a class="hover:underline" href="#" @click.prevent>
                                Проверить адрес
                            </a>
                        </div>
                        <div>
                            Среднее время доставки*:
                            <span class="font-semibold">00:24:19</span>
                        </div>
                    </div>

                    <div class="space-x-10 text-sm items-center lg:flex hidden">
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
                <div class="h-16 flex items-center sm:container sm:mx-auto mx-4 justify-between">
                    <div class="flex items-center h-full lg:justify-start justify-between lg:w-auto w-full">
                        <div class="flex">
                            <pizza-icon class="w-8 h-8"/>
                            <span class="ml-3 text-xl">Куда пицца</span>
                        </div>
                        <nav class="ml-12 h-full lg:flex hidden">
                            <ul class="flex h-full">
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a
                                    class="h-full w-full flex items-center" href="#">Акции</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a
                                    class="h-full w-full flex items-center" href="#">Пицца</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a
                                    class="h-full w-full flex items-center" href="#">Суши</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a
                                    class="h-full w-full flex items-center" href="#">Напитки</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a
                                    class="h-full w-full flex items-center" href="#">Закуски</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a
                                    class="h-full w-full flex items-center" href="#">Комбо</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a
                                    class="h-full w-full flex items-center" href="#">Десерты</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a
                                    class="h-full w-full flex items-center" href="#">Соусы</a></li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white"><a
                                    class="h-full w-full flex items-center" href="#">Другое</a></li>
                            </ul>
                        </nav>
                        <div role="button">
                            <menu-icon/>
                        </div>
                    </div>

                    <nav class="lg:hidden h-[100vh] fixed top-[106px] right-0 w-full z-50 bg-white ">
                        <ul class="uppercase flex flex-col py-4">
                            <li class="px-4 h-full hover:bg-primary hover:text-white w-full">
                                <a class="h-full w-full flex items-center justify-center py-2" href="#">Акции</a>
                            </li>
                            <li class="px-4 h-full hover:bg-primary hover:text-white w-full">
                                <a class="h-full w-full flex items-center justify-center py-2" href="#">Пицца</a>
                            </li>
                            <li class="px-4 h-full hover:bg-primary hover:text-white w-full">
                                <a class="h-full w-full flex items-center justify-center py-2" href="#">Суши</a>
                            </li>
                            <li class="px-4 h-full hover:bg-primary hover:text-white w-full">
                                <a class="h-full w-full flex items-center justify-center py-2" href="#">Напитки</a>
                            </li>
                            <li class="px-4 h-full hover:bg-primary hover:text-white w-full">
                                <a class="h-full w-full flex items-center justify-center py-2" href="#">Закуски</a>
                            </li>
                            <li class="px-4 h-full hover:bg-primary hover:text-white w-full">
                                <a class="h-full w-full flex items-center justify-center py-2" href="#">Комбо</a>
                            </li>
                            <li class="px-4 h-full hover:bg-primary hover:text-white w-full">
                                <a class="h-full w-full flex items-center justify-center py-2" href="#">Десерты</a>
                            </li>
                            <li class="px-4 h-full hover:bg-primary hover:text-white w-full">
                                <a class="h-full w-full flex items-center justify-center py-2" href="#">Соусы</a>
                            </li>
                            <li class="px-4 h-full hover:bg-primary hover:text-white w-full">
                                <a class="h-full w-full flex items-center justify-center py-2" href="#">Другое</a>
                            </li>
                        </ul>
                    </nav>

                    <div class="lg:flex hidden">
                        <div class="bg-primary py-2 px-4 flex space-x-2 rounded-[4px] w-full cursor-pointer">
                            <cart-icon/>
                            <span class="text-white xl:block hidden">
                                0 $
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        <main class="grow">
            <slot/>
        </main>

        <footer class="bg-white py-8">
            <div class="sm:container sm:mx-auto mx-4">
                <div class="grid lg:grid-cols-4  sm:grid-cols-2 grid-cols-1 gap-6">
                    <div class="flex">
                        <pizza-icon class="w-[40px] h-[40px]"/>
                        <span class="ml-3 text-2xl">Куда пицца</span>
                    </div>
                    <div>
                        <h4 class="mb-[22px] text-xl font-bold">Куда пицца</h4>
                        <ul class="space-y-5">
                            <li><a href="#">О компании</a></li>
                            <li><a href="#">Пользовательское соглашение</a></li>
                            <li><a href="#">Условия гарантии</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-[22px] text-xl font-bold">Помощь</h4>
                        <ul class="space-y-5">
                            <li><a href="#">Ресторан</a></li>
                            <li><a href="#">Контакты</a></li>
                            <li><a href="#">Поддержка</a></li>
                            <li><a href="#">Отследить заказ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-[22px] text-xl font-bold">Контакты</h4>
                        <ul class="space-y-5">
                            <li>
                                <a class="flex items-center" href="tel:+3806677889900">
                                    <phone-icon/>
                                    +38 (066) 77-88-9900</a>
                            </li>
                            <li class="flex items-center">
                                <location-icon/>
                                Анката, ул. Вкусной еды, д.7
                            </li>
                            <li>
                                <ul class="flex space-x-6">
                                    <li>
                                        <a class="flex items-center" href="#">
                                            <facebook-icon class="mr-3"/>
                                            Facebook</a>
                                    </li>
                                    <li>
                                        <a class="flex items-center" href="#">
                                            <insta-icon class="mr-3"/>
                                            Instagram</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="lg:mt-0 mt-[37px]">
                    © Copyright 2021 — Куда Пицца
                </div>
            </div>
        </footer>
    </div>
</template>
