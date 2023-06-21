<script lang="ts" setup>
import FlameIcon from "@/Components/Icons/FlameIcon.vue";
import type {IProductDetails} from "@/types/IProductDetails";
import {IOrderEssentials} from "@/types/IOrderEssentials";
import {reactive, ref} from "vue";
import ThinFlameIcon from "@/Components/Icons/ThinFlameIcon.vue";
import CrossIcon from "@/Components/Icons/CrossIcon.vue";

type resolveType = null | IOrderEssentials

let modalController: {
    resolve: (value: PromiseLike<resolveType> | resolveType) => void;
    reject: (reason?: any) => void;
};

const isOpen = ref(false)
const isImageLoaded = ref(false)
const product = ref<IProductDetails | null>(null)
const order = reactive<IOrderEssentials>({
    slug: "",
    thumbnail: "",
    price: 0,
    sale_price: null,
    title: ""
})

const open = (productValue: IProductDetails) => {
    //reset states
    isImageLoaded.value = false


    isOpen.value = true

    product.value = {...productValue}

    const img = new Image()
    img.onload = () => isImageLoaded.value = true
    img.src = productValue.thumbnail

    return new Promise<resolveType>((resolve, reject) => {
        modalController = {resolve, reject}
    });
}


const makeOrder = () => {
    order.slug = product.value!.slug
    order.thumbnail = product.value!.thumbnail
    order.title = product.value!.title
    order.price = product.value!.price
    order.sale_price = product.value!.sale_price

    modalController.resolve(order)

    isOpen.value = false
}


const close = () => {
    modalController.resolve(null)

    isOpen.value = false
}

defineExpose({open})


</script>

<template>
    <div v-if="isImageLoaded && isOpen && product"
         class="w-screen h-screen fixed top-0 right-0 left-0 bg-[#19191966] bg-opacity-40 z-50 flex sm:items-center items-end"
         @click="close">
        <div
            class="relative lg:max-w-[1070px] lg:mx-auto sm:mx-5 sm:rounded-3xl rounded-t-2xl w-full bg-white flex flex-col md:flex-row items-center sm:h-[580px] h-4/5 pt-8 pb-5 md:pr-5 md:animate-appear-slow animate-[emerge_0.35s_ease-in-out]"
            @click.stop>
            <cross-icon class="absolute right-10 top-8 cursor-pointer z-10" @click="close"/>
            <div
                class="md:pl-[60px] relative h-full flex items-center w-full md:w-auto justify-center md:justify-start">
                <div v-if="product!.banner"
                     class="absolute py-[7px] px-[18px] text-sm bg-red-bg text-white uppercase left-0 top-5 rounded-r-md">
                    {{ product!.banner }}
                </div>

                <div class="lg:w-[450px] md:w-[300px] max-w-[300px] md:max-w-full w-full px-5 sm:px-0">
                    <img :src="product!.thumbnail" alt="selected pizza" class="w-full">
                </div>
            </div>

            <div class="md:pl-[60px] px-5">
                <div class="mb-4">
                    <h4 class="text-xl font-semibold flex items-center capitalize">
                        <flame-icon v-if="product!.banner" class="mr-2"/>
                        <thin-flame-icon v-else class="mr-2"/>
                        {{ product!.title }}
                    </h4>
                </div>
                <div class="space-y-4">
                    <div class="space-y-4">
                        <div class="">
                            <h5 class="font-semibold">
                                Состав:
                            </h5>
                            <p>{{ product!.ingredients }}</p>
                        </div>

                        <div class="">
                            <h5 class="font-semibold">
                                Описание:
                            </h5>
                            <p v-html="product!.description"></p>
                        </div>
                    </div>

                    <!--                    <div class="rounded-md border border-gray-border w-full bg-white">
                                            <ul class="flex w-full h-11">
                                                <li v-for="dough_type in Object.keys(DoughTypeEnum)" :key="dough_type"
                                                    :class="{'rounded bg-primary text-white': order.dough_type === DoughTypeEnum[dough_type]}"
                                                    class="cursor-pointer flex items-center justify-center w-1/2 h-full duration-300"
                                                    @click="order.dough_type = DoughTypeEnum[dough_type]">
                                                    {{ DoughTypeEnum[dough_type] }}
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="rounded-md border border-gray-border w-full bg-white">
                                            <ul class="flex w-full h-11">
                                                <li v-for="diameter in Object.keys(PizzaDiameterEnum)" :key="diameter"
                                                    :class="{'rounded bg-primary text-white': order.diameter === PizzaDiameterEnum[diameter]}"
                                                    class="cursor-pointer flex items-center justify-center w-1/3 h-full duration-300"
                                                    @click="order.diameter = PizzaDiameterEnum[diameter]">
                                                    {{ PizzaDiameterEnum[diameter] }} см
                                                </li>
                                            </ul>
                                        </div>-->

                    <div  class="flex justify-between items-center">
                        <div class="flex items-baseline">
                            <div :class="[product!.sale_price ? 'text-red font-semibold' : 'text-primary']"
                                 class="text-xl font-semibold">
                                Итого: {{product!.sale_price || product!.price}}$
                            </div>
                            <div class="text-sm text-gray-text ml-2">
                                400 г
                            </div>
                        </div>


                        <button class="px-10 py-[13px] bg-primary rounded-md text-white ml-5" @click="makeOrder">
                            Добавить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
