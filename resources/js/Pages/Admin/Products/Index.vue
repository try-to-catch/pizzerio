<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3"
import OrangeButton from "@/Components/Form/OrangeButton.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faCircleCheck, faCircleXmark, faPlus} from "@fortawesome/free-solid-svg-icons";
import {onMounted, ref} from "vue";
import {IProduct} from "@/types/IProduct";
import DefaultPagination from "@/Components/DefaultPagination.vue";

interface IProductPagination extends IPagination {
    data: IProduct[];
}

const props = defineProps<{ products: IProductPagination, message?: string }>()

const searchField = ref('')

const filterProducts = () => {
    const searchString = searchField.value

    setTimeout(() => {
        if (searchField.value === searchString) {
            router.reload({
                data: {
                    s: searchString
                }
            })
        }
    }, 1250)
}

onMounted(() => {
    const url = new URL(window.location.href)

    searchField.value = url.searchParams.get('s')
})
</script>

<template>
    <Head><title>Products</title></Head>
    <admin-layout title="Products">
        <div class="px-5 pt-10 flex flex-col">

            <div class="flex items-center justify-between pb-4">
                <div class="sm:w-80 grow sm:grow-0">
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
                            <input id="table-search" v-model="searchField"
                                   class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Search for items"
                                   type="text"
                                   @input="filterProducts">
                        </div>
                    </div>
                </div>
                <Link :href="route('admin.products.create')" class="ml-5">
                    <orange-button class="sm:block hidden">Create product</orange-button>
                    <orange-button class="sm:hidden">
                        <font-awesome-icon :icon="faPlus"/>
                    </orange-button>
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
                            Orders
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
                        <th class="px-6 py-3" scope="col">
                            For sale
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="product in products.data" :key="product.id" class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            <img :alt="`${product.title} thumbnail`" :src="product.thumbnail" class="h-20 w-20"/>
                        </th>
                        <td class="px-6 py-4 capitalize font-semibold">
                            <Link :href="route('admin.products.show', {product: product.slug})">
                                {{ product.title }}
                            </Link>
                        </td>
                        <td class="px-6 py-4">
                            {{ product.price }} $
                        </td>
                        <td class="px-6 py-4">
                            0
                        </td>
                        <td class="px-6 py-4">
                            <Link :href="route('admin.categories.show', {category: product.category.slug})">
                                {{ product.category.title }}
                            </Link>
                        </td>
                        <td class="px-6 py-4">
                            {{ product.user.email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ product.updated_at }}
                        </td>
                        <td class="px-6 py-4">
                            <font-awesome-icon v-if="product.is_for_sale" :icon="faCircleCheck" class="text-green-500"
                                               size="lg"/>
                            <font-awesome-icon v-if="!product.is_for_sale" :icon="faCircleXmark" class="text-red-500"
                                               size="lg"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <default-pagination :links="products.links" class="self-center mt-4 mb-8"/>
        </div>

        <flash-message :message="message"/>
    </admin-layout>
</template>



