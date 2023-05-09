<script lang="ts" setup>
import {Head} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import ProductsGrid from "@/Components/ProductsGrid.vue";
</script>

<template>
    <Head><title>Home</title></Head>

    <main-layout>
        <div class="bg-gray-bg">
            <products-grid class="py-[30px]"/>
        </div>
    </main-layout>
</template>

