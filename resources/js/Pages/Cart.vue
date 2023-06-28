<script lang="ts" setup>

import {Head, useForm} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import type {IOrderEssentialsWithQuantity} from "@/types/IOrderEssentialsWithQuantity";
import {computed, reactive, ref} from "vue";
import CartProductList from "@/Components/CartProductList.vue";
import type {IAuthGlobalData} from "@/types/IAuthGlobalData";
import GrayInput from "@/Components/Form/GrayInput.vue";
import GrayTextArea from "@/Components/Form/GrayTextArea.vue";
import {IPreOrder} from "@/types/IPreOrder";
import {IOrderEssentials} from "@/types/IOrderEssentials";

const {products, auth} = defineProps<{ products: IOrderEssentialsWithQuantity[], auth: IAuthGlobalData, }>()

const mainLayout = ref<InstanceType<typeof MainLayout> | null>(null)

const formattedFinalTotalPrice = computed(() => {
    return mainLayout.value?.cartInstance?.formattedFinalTotalPrice.value;
})

const order = reactive<{ products: IOrderEssentialsWithQuantity[], info: any }>({
    products: [...products],
    info: null
})


const removeFromCart = (product: IOrderEssentials) => {
    mainLayout.value?.cartInstance?.remove(product);

    order.products = order.products.filter(item => item.id !== product.id)
}

const updateCartItem = (val: { product: IOrderEssentialsWithQuantity, values: IProductQuantityValues }) => {
    const {product, values} = val

    setTimeout(() => {
        const lastQuantity = order.products.find(item => item.id === product.id)!.quantity

        if (lastQuantity === values.new) {
            mainLayout.value?.cartInstance?.changeQuantity(product, values)
        }
    }, 1000)
}

const form = useForm<IPreOrder>({
    customer: {
        name: '',
        phone: '',
        email: '',
    },
    destination: {
        street: '',
        house: '',
        entrance: '',
        floor: '',
        apartment: '',
        intercom: '',
    },
    comment: '',
})

//method to submit form
const submit = () => {
    console.log(form.data())

    /*    form.post(route(''), {
            onSuccess: () => {
                mainLayout.value?.displayMessage('Заказ успешно оформлен')
                mainLayout.value?.cartInstance?.clear()
            },
            onError: () => {
                mainLayout.value?.displayMessage('Произошла ошибка')
            }
        })*/
}

</script>

<template>
    <Head><title>Home</title></Head>

    <main-layout ref="mainLayout" :user="auth.user" class="bg-gray-bg">
        <div v-if="order.products.length" class="pt-5 sm:py-10 pb-0">

            <section class="lg:max-w-[850px] max-w-[720px] md:mx-auto mx-5">
                <h2 class="sm:text-[2.5rem] sm:leading-[3rem] text-lg leading-[22px] font-semibold">Ваш заказ</h2>

                <div class="mt-6">
                    <cart-product-list v-model:products="order.products" @removeItem="removeFromCart"
                                       @updateItem="updateCartItem"/>
                </div>
            </section>

            <form @submit.prevent="submit">
                <div class="lg:max-w-[850px] max-w-[720px] md:mx-auto mx-5">
                    <section class="mt-6">
                        <h3 class="text-2xl font-semibold sm:block hidden">О вас</h3>
                        <h3 class="text-lg font-semibold sm:hidden">Личные данные</h3>

                        <div class="mt-4 grid sm:grid-cols-3 grid-cols-1 sm:gap-5 gap-4">
                            <gray-input v-model="form.customer.name" label="Имя" placeholder="Алексей" required/>
                            <gray-input v-model="form.customer.phone" label="Номер телефона" placeholder="+380"
                                        required/>
                            <gray-input v-model="form.customer.email" label="Почта" placeholder="mail@gmail.com"
                                        required/>
                        </div>
                    </section>

                    <div class="border-b border-gray-border w-full my-5"></div>

                    <section>
                        <h3 class="sm:text-2xl font-semibold text-lg">Доставка</h3>

                        <div class="mt-4 grid sm:grid-cols-5 grid-cols-4 gap-x-4 sm:gap-y-5 gap-y-4">
                            <gray-input v-model="form.destination.street" class="col-span-3 sm:col-span-5" label="Улица"
                                        placeholder="Бульвар Шевченко" required/>

                            <gray-input v-model="form.destination.house" label="Дом" placeholder="1a"/>

                            <gray-input v-model="form.destination.entrance" class="col-span-2 sm:col-span-1"
                                        label="Подъезд" placeholder="1"/>

                            <gray-input v-model="form.destination.floor" class="col-span-2 sm:col-span-1" label="Этаж"
                                        placeholder="2"/>

                            <gray-input v-model="form.destination.apartment" class="col-span-2 sm:col-span-1"
                                        label="Квартира" placeholder="3"/>

                            <gray-input v-model="form.destination.intercom" class="col-span-2 sm:col-span-1"
                                        label="Домофон" placeholder="0000"/>
                        </div>
                    </section>

                    <div class="border-b border-gray-border w-full my-5"></div>

                    <section>
                        <h3 class="sm:text-2xl font-semibold text-lg">Комментарий</h3>

                        <div class="mt-4">
                            <gray-text-area id="comment" v-model="form.comment" placeholder="Есть уточнения?"
                                            rows="5"></gray-text-area>
                        </div>
                    </section>
                </div>

                <div
                    class="border-b border-gray-border w-full mt-5 hidden sm:block lg:max-w-[850px] max-w-[720px] md:mx-auto mx-5"></div>

                <section
                    class="mt-4 sm:mt-0 border-y border-y-gray-border sm:border-none px-5 sm:px-0 py-3 sm:py-5 bg-white sm:bg-transparent flex items-center justify-between lg:max-w-[850px] sm:max-w-[720px] md:mx-auto sm:mx-5">
                    <div class="text-lg sm:text-xl text-primary font-semibold">
                        Итого: {{ formattedFinalTotalPrice }}
                    </div>

                    <button class="bg-primary text-white text-sm sm:text-base rounded-md px-6 py-[13px]">
                        Оформить заказ
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
