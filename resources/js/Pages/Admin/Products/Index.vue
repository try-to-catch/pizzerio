<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link} from "@inertiajs/vue3"
import OrangeButton from "@/Components/Form/OrangeButton.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

interface IProduct {
    id: number,
    slug: string,
    title: string,
    price: number,
    thumbnail: string,
    updated_at: string,
    created_by?: string,
    category_title: string,
    category_slug: string,
}

const {products, message} = defineProps<{ products: IProduct[], message?: string }>()

</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories">
        <div class="px-5 pt-10">

            <div class="flex justify-between pb-4">
                <div class="">
                    <div class="bg-white">
                        <label class="sr-only" for="table-search">Search</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500"
                                     fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          fill-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input id="table-search"
                                   class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Search for items"
                                   type="text">
                        </div>
                    </div>
                </div>
                <Link :href="route('admin.products.create')"
                >
                    <orange-button>Create product</orange-button>
                </Link>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-b-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3" scope="col">
                            Thumbnail
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Title
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Price
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Number of orders
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Category title
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Created By
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Last Update
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="product in products" :key="product.id" class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            <img :alt="`${product.title} thumbnail`" :src="product.thumbnail" class="h-5 w-5"/>
                        </th>
                        <td class="px-6 py-4">
                            <Link :href="route('admin.products.show', {product: product.slug})">
                                {{ product.title }}
                            </Link>
                        </td>
                        <td class="px-6 py-4">
                            {{product.price}} $
                        </td>
                        <td class="px-6 py-4 pl-20">
                            0
                        </td>
                        <td class="px-6 py-4">
                            <Link :href="route('admin.categories.show', {category: product.category_slug})">
                                {{ product.category_title }}
                            </Link>
                        </td>
                        <td class="px-6 py-4">
                            {{ product.created_by }}
                        </td>
                        <td class="px-6 py-4">
                            {{ product.updated_at }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <flash-message :message="message"/>
    </admin-layout>
</template>



