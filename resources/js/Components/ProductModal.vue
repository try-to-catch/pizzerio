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
    <div v-if="isImageLoaded && isOpen"
         class="w-screen h-screen fixed top-0 right-0 left-0 bg-[#19191966] bg-opacity-40 z-50 flex items-center animate-appear-slow"
         @click="close">
        <div class="relative max-w-[1070px] mx-auto rounded-3xl w-full bg-white flex items-center h-[580px] pt-8 pb-5 pr-5"
             @click.stop>
            <cross-icon  @click="close" class="absolute right-10 top-8 cursor-pointer lg:block hidden"/>
            <div class="pl-[60px] relative h-full flex items-center">
                <div v-if="product!.banner"
                     class="absolute py-[7px] px-[18px] text-sm bg-red-bg text-white uppercase left-0 top-5 rounded-r-md">
                    {{ product!.banner }}
                </div>

                <div class="w-[450px] h-[450px]">
                    <img :src="product!.thumbnail" alt="selected pizza" class="w-full">
                </div>
            </div>

            <div class="pl-[60px]">
                <div class="mb-4">
                    <h4 class="text-xl font-semibold flex items-center capitalize">
                        <flame-icon v-if="product!.sale_price" class="mr-2"/>
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

                    <div class="flex justify-between items-center">
                        <div class="flex items-baseline">
                            <div class="text-xl font-semibold text-primary">
                                Итого: 123$
                            </div>
                            <div class="text-sm text-gray-text ml-2">
                                400 г
                            </div>
                        </div>


                        <button class="px-10 py-[13px] bg-primary rounded-md text-white" @click="makeOrder">
                            Добавить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
