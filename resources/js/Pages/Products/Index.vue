<script lang="ts" setup>
import {Head} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import ProductsGrid from "@/Components/ProductsGrid.vue";
</script>

<template>
    <Head><title>Home</title></Head>

    <main-layout>
        <div class="bg-gray-bg">
            <div class="bg-gray-350">
                <div class="sm:container sm:mx-auto mx-5">
                    <products-grid class="py-[30px]"/>
                </div>
            </div>
        </div>
    </main-layout>
</template>

