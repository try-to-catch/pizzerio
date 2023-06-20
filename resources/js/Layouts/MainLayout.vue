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
import {Link, router} from "@inertiajs/vue3";
import {IUserEssentials} from "@/types/IUserEssentials";
import UseCart from "@/composables/Cart";
import type {IOrderEssentialsWithQuantity} from "@/types/IOrderEssentialsWithQuantity";

const {user} = defineProps<{ user?: IUserEssentials }>()

const isActionListOpen = ref(false)
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

const cartInstance = new UseCart()
const cart = ref<IOrderEssentialsWithQuantity[]>(cartInstance.cart)

onMounted(() => {
    addEventListener('resize', resizeEvent)
})

onUnmounted(() => {
    removeEventListener('resize', resizeEvent)
})

const isOverlayOpen = computed(() => {
    return width.value < 1024 && isMenuOpen.value
})

const headerHeight = computed((): 106 | 66 => {
    return window.location.pathname === '/' ? 106 : 66;
})

const formattedCartItemsCount = computed((): "9+" | number => {
    const cartItemsCount = cart.value.length

    if (cartItemsCount > 9) {
        return '9+'
    }

    return cartItemsCount
})

const formattedCartTotalPrice = computed((): string => {
    const total = cart.value.reduce((acc, item) => {
        return acc + item.price * item.quantity
    }, 0)

    return (total > 999 ? '999+' : total) + '$'
})

const message = ref('')
const isMessageShouldBeDisplayed = ref(false)

const displayMessage = (messageText: string) => {
    message.value = messageText

    isMessageShouldBeDisplayed.value = true

    setTimeout(() => {
        isMessageShouldBeDisplayed.value = false
    }, 5000)
}

const logout = () => {
    router.post(route('logout'));
}



defineExpose({cartInstance, displayMessage})
</script>

<template>
    <div class="font-sans-serif w-full min-h-[100vh] flex flex-col justify-between">
        <header class="fixed top-0 right-0 w-full z-30">
            <!--top header-->
            <div :class="{hidden: !$page.url.startsWith('/')}" class="bg-white">
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
                        <div v-if="!user">
                            <Link :href="route('login')" class="text-sm flex items-center">
                                <person-icon/>
                                <span class="hover:underline ml-2">Войти в аккаунт</span>
                            </Link>
                        </div>
                        <div v-else class="relative bg-white h-full flex z-20" @mouseleave="isActionListOpen= false"
                             @mouseover="isActionListOpen = true">
                            <button class="flex items-center justify-end bg-white h-full z-10 min-w-[80px]">
                                <span class="ml-2 font-semibold">{{ user.name }}</span>
                            </button>
                            <transition name="action-list">
                                <div v-if="isActionListOpen"
                                     class="absolute right-[1px] bg-white border border-gray-200 min-w-[78px] -z-10 top-10">
                                    <ul class="px-2">
                                        <li>
                                            <button class="flex flex-col  py-2 text-sm" @click="logout">Выйти</button>
                                        </li>
                                    </ul>
                                </div>
                            </transition>
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
                        <nav :class="{'lg:flex': !$page.url.startsWith('/')}"
                             class="ml-12 lg:ml-3 xl:ml-12 h-full  hidden">
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
                        <div class="lg:hidden block" role="button" @click="isMenuOpen = !isMenuOpen">
                            <menu-icon v-if="!isOverlayOpen" class="h-8 w-8 "/>
                            <cross-icon v-if="isOverlayOpen" class="h-8 w-8"/>
                        </div>
                    </div>

                    <div class="lg:flex hidden">
                        <div class="bg-primary py-2 px-4 flex space-x-2 rounded-[4px] w-full cursor-pointer">
                            <cart-icon/>
                            <span :class="[!$page.url.startsWith('/')? 'xl:block hidden': 'block']" class="text-white">
                                {{ formattedCartTotalPrice }}
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
                    <Link v-if="!user" :href="route('login')"
                          class="text-sm flex items-center sm:container sm:mx-auto mx-5">
                        <person-icon/>
                        <span class="hover:underline ml-4 text-[17px]">Войти в аккаунт</span>
                    </Link>
                    <div v-else class="flex items-center sm:container sm:mx-auto mx-5">
                        <button class="flex flex-col font-semibold py-2" @click="logout">Выйти из аккаунта</button>
                    </div>
                </div>
                <div class="py-2 border-b border-gray-200">
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

        <main :style="{marginTop: headerHeight + 'px'}" class="grow relative">
            <transition mode="in-out"  duration="300" name="fade">
                <div v-if="isMessageShouldBeDisplayed" :style="{top: headerHeight + 16 +'px'}"
                     class="fixed flex justify-center w-full z-20">
                    <div class="py-3 px-8  text-white bg-primary rounded-full text-sm sm:text-base cursor-pointer"
                         @click="isMessageShouldBeDisplayed = false">
                        {{ message }}
                    </div>
                </div>
            </transition>

            <slot/>

            <div
                class="fixed bottom-5 right-5 z-40 cursor-pointer p-4 bg-primary hover:bg-orange-600 ease-in-out duration-300 rounded-full flex lg:hidden">
                <cart-icon class="w-6 h-6"/>
                <div
                    class="absolute -top-0.5 -right-0.5 bg-white border border-primary text-primary w-5 h-5 flex justify-center items-center rounded-full text-xs">
                    {{ formattedCartItemsCount }}
                </div>
            </div>
        </main>

        <footer class="bg-white py-8">
            <div class="sm:container sm:mx-auto mx-5">
                <div class="grid lg:grid-cols-4  sm:grid-cols-2 grid-cols-1 gap-6">
                    <div class="flex">
                        <pizza-icon class="md:w-[40px] md:h-[40px]  w-8 h-8 "/>
                        <span class="ml-3 md:text-2xl text-lg">Куда пицца</span>
                    </div>
                    <div class="text-sm sm:text-base">
                        <h4 class="mb-[22px] md:text-xl font-bold">Куда пицца</h4>
                        <ul class="space-y-4 md:space-y-5">
                            <li><a href="#">О компании</a></li>
                            <li><a href="#">Пользовательское соглашение</a></li>
                            <li><a href="#">Условия гарантии</a></li>
                        </ul>
                    </div>
                    <div class="text-sm sm:text-base">
                        <h4 class="mb-[22px] md:text-xl font-bold">Помощь</h4>
                        <ul class="space-y-4 md:space-y-5">
                            <li><a href="#">Ресторан</a></li>
                            <li><a href="#">Контакты</a></li>
                            <li><a href="#">Поддержка</a></li>
                            <li><a href="#">Отследить заказ</a></li>
                        </ul>
                    </div>
                    <div class="text-sm sm:text-base">
                        <h4 class="mb-[22px] md:text-xl font-bold">Контакты</h4>
                        <main-footer class="space-y-4 md:space-y-5"/>
                    </div>
                </div>
                <div class="lg:mt-0 mt-[37px] text-sm sm:text-base">
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

.action-list-enter-active {
    transform: translateY(0);
    transition: transform 0.4s ease-in-out;
}

.action-list-leave-active {
    transform: translateY(0);
    transition: transform 0.2s ease-in-out;
}

.action-list-enter-from,
.action-list-leave-to {
    transform: translateY(-40px);
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
