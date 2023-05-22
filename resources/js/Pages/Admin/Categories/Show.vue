<script lang="ts" setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import {ICategory} from "@/types/ICategory";

const {category, numberOfRelatedProducts} = defineProps<{ category: ICategory, numberOfRelatedProducts: number }>()

const deleteCategory = () => router.delete(`/admin/categories/${category.slug}`)

</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout :title="`Categories - ${category.title}`">
        <div class="px-5 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.edit', {category: category.slug})"
                      class="pt-2.5 pb-1.5 px-4 bg-blue-400 text-white rounded-t-md mr-2">
                    Edit
                </Link>
                <button class="pt-2.5 pb-1.5 px-4 bg-red-400 text-white rounded-t-md mr-8" @click="deleteCategory">
                    Delete
                </button>
                <Link :href="route('admin.categories.index')"
                      class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-b-lg">
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
                            Title
                        </th>
                        <td class="px-6 py-4">
                            {{ category.title }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Icon
                        </th>
                        <td class="px-6 py-4">
                            <img :alt="category.title" :src="category.icon" class="h-8 w-8"/>
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Created By
                        </th>
                        <td class="px-6 py-4">
                            {{ category.created_by }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Created At
                        </th>
                        <td class="px-6 py-4">
                            {{ category.created_at }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            Last Update
                        </th>
                        <td class="px-6 py-4">
                            {{ category.updated_at }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
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
