<script lang="ts" setup>
import type {IAuthGlobalData} from "@/types/IAuthGlobalData";
import MainLayout from "@/Layouts/MainLayout.vue";
import {Head} from "@inertiajs/vue3";

const {order_id, auth} = defineProps<{ order_id: number, auth: IAuthGlobalData, }>()


</script>

<template>
    <Head><title>Thanks for order</title></Head>

    <main-layout ref="mainLayout" :user="auth.user" class="bg-gray-bg">
        <div class=" sm:min-h-[840px] min-h-[733px] flex items-center justify-center">
            <div class="flex flex-col items-center text-center mx-5">
                <div>
                    <img alt="delivery-boy" src="/images/delivery-boy.svg">
                </div>

                <h3 class="text-2xl font-semibold mt-12">Заказ №{{ order_id }} принят</h3>

                <p class="mt-4">
                    Спасибо за заказ!<br class="sm:block hidden"> Примерное время доставки 45 минут. Статус<br
                    class="sm:block hidden"> отследить можно позвонив по
                    горячему номеру <span class="block font-semibold">+38 (066) 777-88-99</span>
                </p>
            </div>
        </div>
    </main-layout>
</template>
