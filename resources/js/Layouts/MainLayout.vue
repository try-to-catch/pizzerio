<script lang="ts" setup>

import LocationIcon from "@/Components/Icons/LocationIcon.vue";
import PersonIcon from "@/Components/Icons/PersonIcon.vue";
import PizzaIcon from "@/Components/Icons/PizzaIcon.vue";
import CartIcon from "@/Components/Icons/CartIcon.vue";
import MenuIcon from "@/Components/Icons/MenuIcon.vue";
import {computed, onMounted, onUnmounted, ref} from "vue";
import {IResizeEventTarget} from "@/types/IResizeEventTarget";
import CrossIcon from "@/Components/Icons/CrossIcon.vue";
import MainFooter from "@/Components/MainFooter.vue";
import {Link} from "@inertiajs/vue3";

const isMenuOpen = ref(false)
const width = ref(window.innerWidth)
const height = ref(window.innerHeight)

const resizeEvent = (ev) => {
    const target = ev.target as IResizeEventTarget
    width.value = window.innerWidth
    height.value = window.innerHeight

    if (target.innerWidth >= 1024) {
        isMenuOpen.value = false
    }
};

onMounted(() => {
    addEventListener('resize', resizeEvent)
})

onUnmounted(() => {
    removeEventListener('resize', resizeEvent)
})

const isOverlayOpen = computed(() => {
    return width.value < 1024 && isMenuOpen.value
})

const headerHeight = computed(() => {
    return window.location.pathname === '/' ? 106 : 66;
})
</script>

<template>
    <div class="font-sans-serif w-full min-h-[100vh] flex flex-col justify-between">
        <header class="fixed top-0 right-0 w-full z-30">
            <!--top header-->
            <div :class="{hidden: $page.url !== '/'}" class="bg-white">
                <div class="h-10 flex justify-between sm:container sm:mx-auto mx-5">
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
            <!--bottom header-->
            <div class="border-y border-gray-200 bg-white">
                <div class="h-16 flex items-center sm:container sm:mx-auto mx-5 justify-between">
                    <div class="flex items-center h-full lg:justify-start justify-between lg:w-auto w-full">
                        <Link :href="route('home')" class="flex">
                            <pizza-icon class="w-8 h-8"/>
                            <span class="ml-3 md:text-xl whitespace-nowrap text-lg">Куда пицца</span>
                        </Link>
                        <nav :class="{'lg:flex': $page.url !== '/'}" class="ml-12 lg:ml-3 xl:ml-12 h-full  hidden">
                            <ul class="flex h-full">
                                <li class="px-4 h-full hover:bg-primary hover:text-white">
                                    <a class="h-full w-full flex items-center" href="#">Акции</a>
                                </li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white">
                                    <a class="h-full w-full flex items-center" href="#">Пицца</a>
                                </li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white">
                                    <a class="h-full w-full flex items-center" href="#">Суши</a>
                                </li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white">
                                    <a class="h-full w-full flex items-center" href="#">Напитки</a>
                                </li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white">
                                    <a class="h-full w-full flex items-center" href="#">Закуски</a>
                                </li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white">
                                    <a class="h-full w-full flex items-center" href="#">Комбо</a>
                                </li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white">
                                    <a class="h-full w-full flex items-center" href="#">Десерты</a>
                                </li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white">
                                    <a class="h-full w-full flex items-center" href="#">Соусы</a>
                                </li>
                                <li class="px-4 h-full hover:bg-primary hover:text-white">
                                    <a class="h-full w-full flex items-center" href="#">Другое</a>
                                </li>
                            </ul>
                        </nav>
                        <div v-if="!isOverlayOpen" class="lg:hidden block" role="button" @click="isMenuOpen = true">
                            <menu-icon/>
                        </div>
                        <div v-if="isOverlayOpen" class="lg:hidden block" role="button" @click="isMenuOpen = false">
                            <cross-icon class="h-8 w-8"/>
                        </div>
                    </div>

                    <div class="lg:flex hidden">
                        <div class="bg-primary py-2 px-4 flex space-x-2 rounded-[4px] w-full cursor-pointer">
                            <cart-icon/>
                            <span :class="[$page.url !== '/'? 'xl:block hidden': 'block']" class="text-white">
                                0 $
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!--overlay-->
        <transition name="overlay">
            <nav v-if="isOverlayOpen" :style="{height: height - headerHeight + 'px', top: headerHeight + 'px'}"
                 class="lg:hidden fixed right-0 w-full z-20 bg-white">
                <div class="py-4 text-center">
                    <a class="text-sm flex items-center sm:container sm:mx-auto mx-5" href="#" @click.prevent>
                        <person-icon/>
                        <span class="hover:underline ml-4 text-[17px]">
                        Войти в аккаунт
                    </span>
                    </a>
                </div>
                <div class="py-2 border-y border-gray-200">
                    <ul class="normal-case flex flex-col sm:container sm:mx-auto mx-5">
                        <li class="h-full hover:bg-primary hover:text-white w-full">
                            <a class="w-full flex py-2" href="#">Акции</a>
                        </li>
                        <li class="h-full hover:bg-primary hover:text-white w-full">
                            <a class="w-full flex py-2" href="#">О компании</a>
                        </li>
                        <li class="h-full hover:bg-primary hover:text-white w-full">
                            <a class="w-full flex py-2" href="#">Пользовательское соглашение</a>
                        </li>
                        <li class="h-full hover:bg-primary hover:text-white w-full">
                            <a class="w-full flex py-2" href="#">Условия гарантии</a>
                        </li>
                        <li class="h-full hover:bg-primary hover:text-white w-full">
                            <a class="w-full flex py-2" href="#">Ресторан</a>
                        </li>
                        <li class="h-full hover:bg-primary hover:text-white w-full">
                            <a class="w-full flex py-2" href="#">Контакты</a>
                        </li>
                        <li class="h-full hover:bg-primary hover:text-white w-full">
                            <a class="w-full flex py-2" href="#">Поддержка</a>
                        </li>
                        <li class="h-full hover:bg-primary hover:text-white w-full">
                            <a class="w-full flex py-2" href="#">Отследить заказ</a>
                        </li>
                    </ul>
                </div>

                <main-footer class="space-y-4 md:space-y-5 mt-5 sm:container sm:mx-auto mx-5"/>

                <div
                    class="text-gray-400 text-md py-4 border-y border-gray-300 text-center w-full absolute bottom-0 right-0">
                    Время работы:
                    с
                    11:00 до 23:00
                </div>
            </nav>
        </transition>

        <main :style="{marginTop: headerHeight + 'px'}" class="grow">
            <slot/>
        </main>

        <footer class="bg-white py-8">
            <div class="sm:container sm:mx-auto mx-5">
                <div class="grid lg:grid-cols-4  sm:grid-cols-2 grid-cols-1 gap-6">
                    <div class="flex">
                        <pizza-icon class="md:w-[40px] md:h-[40px]  w-8 h-8 "/>
                        <span class="ml-3 md:text-2xl text-lg">Куда пицца</span>
                    </div>
                    <div>
                        <h4 class="mb-[22px] md:text-xl font-bold">Куда пицца</h4>
                        <ul class="space-y-4 md:space-y-5">
                            <li><a href="#">О компании</a></li>
                            <li><a href="#">Пользовательское соглашение</a></li>
                            <li><a href="#">Условия гарантии</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-[22px] md:text-xl font-bold">Помощь</h4>
                        <ul class="space-y-4 md:space-y-5">
                            <li><a href="#">Ресторан</a></li>
                            <li><a href="#">Контакты</a></li>
                            <li><a href="#">Поддержка</a></li>
                            <li><a href="#">Отследить заказ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-[22px] md:text-xl font-bold">Контакты</h4>
                        <main-footer class="space-y-4 md:space-y-5"/>
                    </div>
                </div>
                <div class="lg:mt-0 mt-[37px]">
                    © Copyright 2021 — Куда Пицца
                </div>
            </div>
        </footer>
    </div>
</template>


<style scoped>
.overlay-enter-active,
.overlay-leave-active {
    transform: translateY(0);
    transition: transform 0.8s ease-in-out;
}

.overlay-enter-from,
.overlay-leave-to {
    transform: translateY(calc(-100vh + 66px));
}
</style>
