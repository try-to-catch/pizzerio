<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import {ICategory} from "@/types/ICategory";

const {category, numberOfRelatedProducts} = defineProps<{category: ICategory, numberOfRelatedProducts: number}>()


</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories - Create">
        <div class="px-5 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.edit', {category: category.slug})" class="pt-2.5 pb-1.5 px-4 bg-blue-400 text-white rounded-t-md mr-2">
                    Edit
                </Link>
                <Link :href="route('admin.categories.destroy', {category: category.slug})" class="pt-2.5 pb-1.5 px-4 bg-red-400 text-white rounded-t-md mr-8">
                    Delete
                </Link>
                <Link :href="route('admin.categories.index')" class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-b-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Field
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Value
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            Title
                        </th>
                        <td class="px-6 py-4">
                            {{ category.title }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            Icon
                        </th>
                        <td class="px-6 py-4">
                            <img :src="category.icon" class="h-8 w-8" :alt="category.title"/>
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            Created
                        </th>
                        <td class="px-6 py-4">
                            {{ category.created_at }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            Last update
                        </th>
                        <td class="px-6 py-4">
                            {{ category.updated_at }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            Number of related products
                        </th>
                        <td class="px-6 py-4">
                            {{ numberOfRelatedProducts }}
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </admin-layout>
</template>
