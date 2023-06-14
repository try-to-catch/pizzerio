<script lang="ts" setup>
import FlameIcon from "@/Components/Icons/FlameIcon.vue";
import type {IProductDetails} from "@/types/IProductDetails";
import {DoughTypeEnum, IOrderEssentials, PizzaDiameterEnum} from "@/types/IOrderEssentials";
import {useForm} from "@inertiajs/vue3";

const {product} = defineProps<{ product: IProductDetails }>()

const emit = defineEmits<{(e: 'modalClose'):void}>()

const form = useForm<IOrderEssentials>({
    diameter: PizzaDiameterEnum.Small,
    dough_type: DoughTypeEnum.Traditional,
    slug: "",
    thumbnail: "",
    title: ""
})


const closeModal = () => emit('modalClose')
</script>

<template>
    <div @click="closeModal" class="w-screen h-screen fixed top-0 right-0 left-0 bg-[#19191966] bg-opacity-40 z-50 flex items-center">
        <div @click.stop class="max-w-[1070px] mx-auto rounded-3xl w-full bg-white flex items-center h-[580px] pt-8 pb-5 pr-5">
            <div class="pl-[60px] relative h-full flex items-center">
                <div
                    class="absolute py-[7px] px-[18px] text-sm bg-red-bg text-white uppercase left-0 top-5 rounded-r-md">
                    new
                </div>

                <div class="w-[450px] h-[450px]">
                    <img alt="selected pizza" class="w-full" src="/images/nice-pizza.png">
                </div>
            </div>

            <div class="pl-[60px]">
                <div class="mb-4">
                    <h4 class="text-xl font-semibold flex items-center">
                        <flame-icon class="mr-2"/>
                        Пепперони по-деревенски
                    </h4>
                </div>
                <div class="space-y-4">
                    <div class="space-y-4">
                        <div class="">
                            <h5 class="font-semibold">
                                Состав:
                            </h5>
                            <p>Курица, Лук, Перец Халапеньо, Сыр Моцарелла, Томатный соус, Паприка, Майонез</p>
                        </div>

                        <div class="">
                            <h5 class="font-semibold">
                                Описание:
                            </h5>
                            <p>Курица, Лук, Перец Халапеньо, Сыр Моцарелла, Томатный соус, Паприка, Майонез. Что еще
                                нужно для вкусной пиццы? Может быть немного соли</p>
                        </div>
                    </div>

                    <div class="rounded-md border border-gray-border w-full bg-white">
                        <ul class="flex w-full h-11">
                            <li v-for="dough_type in Object.keys(DoughTypeEnum)" :key="dough_type"
                                :class="{'rounded bg-primary text-white': form.dough_type === DoughTypeEnum[dough_type]}"
                                class="cursor-pointer flex items-center justify-center w-1/2 h-full duration-300"
                                @click="form.dough_type = DoughTypeEnum[dough_type]">
                                {{ DoughTypeEnum[dough_type] }}
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-md border border-gray-border w-full bg-white">
                        <ul class="flex w-full h-11">
                            <li v-for="diameter in Object.keys(PizzaDiameterEnum)" :key="diameter"
                                :class="{'rounded bg-primary text-white': form.diameter === PizzaDiameterEnum[diameter]}"
                                class="cursor-pointer flex items-center justify-center w-1/3 h-full duration-300"
                                @click="form.diameter = PizzaDiameterEnum[diameter]">
                                {{ PizzaDiameterEnum[diameter] }} см
                            </li>
                        </ul>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="flex items-baseline">
                            <div class="text-xl font-semibold text-primary">
                                Итого: 123$
                            </div>
                            <div class="text-sm text-gray-text ml-2">
                                400 г
                            </div>
                        </div>


                        <button class="px-10 py-[13px] bg-primary rounded-md text-white">
                            Добавить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<style>
.active {
    transition: 3s;
}
</style>
