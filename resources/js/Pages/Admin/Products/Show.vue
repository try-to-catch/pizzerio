<script lang="ts" setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import type {IExtendedProduct} from "@/types/IExtendedProduct";
import {computed} from "vue";
import StatusIcon from "@/Components/StatusIcon.vue";

const {product, number_of_related_orders} = defineProps<{
    product: IExtendedProduct,
    number_of_related_orders: number
}>()

const deleteProduct = () => {
    router.delete(`/admin/products/${product.slug}`)
}

const formattedSalePrice = computed(() => {
    const price = product.sale_price

    return price ? `${price} $` : ''
})

</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout :title="`Categories - ${product.title}`">
        <div class="px-5 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.products.edit', {product: product.slug})"
                      class="pt-2.5 pb-1.5 px-4 bg-blue-400 text-white rounded-t-md mr-2">
                    Edit
                </Link>
                <button class="pt-2.5 pb-1.5 px-4 bg-red-400 text-white rounded-t-md mr-8" @click="deleteProduct">
                    Delete
                </button>
                <Link :href="route('admin.products.index')"
                      class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-b-lg mb-8">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3" scope="col">
                            Field
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Value
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Thumbnail
                        </th>
                        <td class="px-6 py-4">
                            <img :alt="product.title" :src="product.thumbnail" class="h-40 w-40"/>
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Title
                        </th>
                        <td class="px-6 py-4">
                            {{ product.title }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Description
                        </th>
                        <td class="px-6 py-4">
                            {{ product.description }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Ingredients
                        </th>
                        <td class="px-6 py-4">
                            {{ product.ingredients }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Price
                        </th>
                        <td class="px-6 py-4">
                            {{ product.price }} $
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Sale Price
                        </th>
                        <td class="px-6 py-4">
                            {{ formattedSalePrice }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Priority
                        </th>
                        <td class="px-6 py-4">
                            {{ product.priority }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            For Sale
                        </th>
                        <td class="px-6 py-4">
                            <status-icon :is-success="product.is_for_sale"/>
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Banner Text
                        </th>
                        <td class="px-6 py-4">
                            {{ product.banner }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Category
                        </th>
                        <td class="px-6 py-4">
                            <Link :href="route('admin.categories.show', {category: product.category.slug})"
                                  class="hover:underline">
                                {{ product.category.title }}
                            </Link>
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Created By
                        </th>
                        <td class="px-6 py-4">
                            {{ product.user.email }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Created At
                        </th>
                        <td class="px-6 py-4">
                            {{ product.created_at }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Last Update
                        </th>
                        <td class="px-6 py-4">
                            {{ product.updated_at }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Number of related orders
                        </th>
                        <td class="px-6 py-4">
                            {{ number_of_related_orders }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </admin-layout>
</template>
