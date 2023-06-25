<script lang="ts" setup>

import {Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import type {IOrderEssentialsWithQuantity} from "@/types/IOrderEssentialsWithQuantity";
import {reactive} from "vue";
import CartProductList from "@/Components/CartProductList.vue";
import axios from "axios";


const {products} = defineProps<{ products: IOrderEssentialsWithQuantity[] }>()

console.log(products)


const order = reactive<{ products: IOrderEssentialsWithQuantity[], info: any }>({
    products: [],
    info: null
})

order.products.push(...products)

const removeFromCart = (id: number) => {
    axios.delete(route('cart.remove', {productId: id}))

    order.products = order.products.filter(product => product.id !== id)
}

const updateCartItem = (val: { id: number, quantity: number }) => {
    const {id, quantity} = val

    setTimeout(() => {
        const lastQuantity = order.products.find(product => product.id === id)!.quantity

        if (lastQuantity === quantity) {
            axios.patch(route('cart.update', {productId: id}), {quantity})
        }
    }, 1000)
}
</script>

<template>
    <Head><title>Home</title></Head>

    <main-layout ref="mainLayout" class="bg-gray-bg">
        <div class="lg:max-w-[850px] max-w-[720px] md:mx-auto mx-5 py-10 pb-[60px]">
            <h2 class="sm:text-[2.5rem] sm:leading-[3rem] text-lg leading-[22px] font-semibold">Ваш заказ</h2>

            <div class="mt-6">
                <cart-product-list v-model:products="order.products" @removeItem="removeFromCart"
                                   @updateItem="updateCartItem"/>
            </div>
        </div>
    </main-layout>
</template>

<style scoped>

</style>
