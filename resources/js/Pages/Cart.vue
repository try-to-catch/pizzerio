<script lang="ts" setup>

import {Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import type {IOrderEssentialsWithQuantity} from "@/types/IOrderEssentialsWithQuantity";
import {reactive} from "vue";
import CartProductList from "@/Components/CartProductList.vue";
import Cart from "@/composables/Cart";
import type {IAuthData} from "@/types/IAuthData";
import GrayInput from "@/Components/Form/GrayInput.vue";
import GrayTextArea from "@/Components/Form/GrayTextArea.vue";

const {products, auth} = defineProps<{ products: IOrderEssentialsWithQuantity[], auth: IAuthData, }>()

const cart = new Cart()

const order = reactive<{ products: IOrderEssentialsWithQuantity[], info: any }>({
    products: [],
    info: null
})

order.products.push(...products)

const removeFromCart = (id: number) => {
    cart.remove(id);

    order.products = order.products.filter(product => product.id !== id)
}

const updateCartItem = (val: { id: number, quantity: number }) => {
    const {id, quantity} = val

    setTimeout(() => {
        const lastQuantity = order.products.find(product => product.id === id)!.quantity

        if (lastQuantity === quantity) {
            cart.changeQuantity(id, quantity)
        }
    }, 1000)
}
</script>

<template>
    <Head><title>Home</title></Head>

    <main-layout ref="mainLayout" :user="auth.user" class="bg-gray-bg">
        <div v-if="order.products.length" class="pt-5 sm:pt-10">

            <section class="lg:max-w-[850px] max-w-[720px] md:mx-auto mx-5">
                <h2 class="sm:text-[2.5rem] sm:leading-[3rem] text-lg leading-[22px] font-semibold">Ваш заказ</h2>

                <div class="mt-6">
                    <cart-product-list v-model:products="order.products" @removeItem="removeFromCart"
                                       @updateItem="updateCartItem"/>
                </div>
            </section>

            <form>
                <div class="lg:max-w-[850px] max-w-[720px] md:mx-auto mx-5">
                    <section class="mt-6">
                        <h3 class="text-2xl font-semibold sm:block hidden">О вас</h3>
                        <h3 class="text-lg font-semibold sm:hidden">Личные данные</h3>
                        <div class="mt-4 grid sm:grid-cols-3 grid-cols-1 sm:gap-5 gap-4">
                            <gray-input label="Улица" placeholder="Бульвар Шевченко" required/>
                            <gray-input label="Дом" placeholder="1a"/>
                            <gray-input label="Подьезд" placeholder="1"/>

                        </div>
                    </section>

                    <div class="border-b border-gray-border w-full my-5"></div>

                    <section>
                        <h3 class="sm:text-2xl font-semibold text-lg">Доставка</h3>

                        <div class="mt-4 grid sm:grid-cols-5 grid-cols-4 gap-x-4 sm:gap-y-5 gap-y-4">
                            <gray-input class="col-span-3 sm:col-span-5" label="Улица" placeholder="Бульвар Шевченко"
                                        required/>
                            <gray-input label="Дом" placeholder="1a"/>
                            <gray-input class="col-span-2 sm:col-span-1" label="Подьезд" placeholder="1"/>
                            <gray-input class="col-span-2 sm:col-span-1" label="Этаж" placeholder="2"/>
                            <gray-input class="col-span-2 sm:col-span-1" label="Квартира" placeholder="3"/>
                            <gray-input class="col-span-2 sm:col-span-1" label="Домофон" placeholder="0000"/>
                        </div>
                    </section>

                    <div class="border-b border-gray-border w-full my-5"></div>

                    <section>
                        <h3 class="sm:text-2xl font-semibold text-lg">Комментарий</h3>

                        <div class="mt-4">
                            <gray-text-area id="comment" placeholder="Есть уточнения?" rows="5"></gray-text-area>
                        </div>
                    </section>
                </div>

                <div
                    class="border-b border-gray-border w-full mt-5 hidden sm:block lg:max-w-[850px] max-w-[720px] md:mx-auto mx-5"></div>

                <section
                    class="mt-4 sm:mt-0 border-y border-y-gray-border sm:border-none px-5 sm:px-0 py-3 sm:py-5 bg-white sm:bg-transparent flex items-center justify-between lg:max-w-[850px] sm:max-w-[720px] md:mx-auto sm:mx-5">
                <span class="text-lg sm:text-xl text-primary font-semibold">
                    Итого: 2 379 ₽
                </span>

                    <button class="bg-primary text-white text-sm sm:text-base rounded-md px-6 py-[13px]">Оформить заказ
                    </button>
                </section>
            </form>
        </div>

        <div v-else class="lg:max-w-[850px] max-w-[720px] md:mx-auto mx-5 py-10 pb-[60px] text-lg min-h-[50vh]">
            <h2 class="sm:text-[2.5rem] sm:leading-[3rem] text-lg leading-[22px] font-semibold">Пицца не найденна</h2>
            <p class="text-sm sm:text-base">
                Корзина пуста, выбирайте быстрее, пока пицца не остыла!
            </p>
        </div>
    </main-layout>
</template>
