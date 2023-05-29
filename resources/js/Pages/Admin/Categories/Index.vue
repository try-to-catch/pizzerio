<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link} from "@inertiajs/vue3"
import {ICategory} from "@/types/ICategory";
import FlashMessage from "@/Components/FlashMessage.vue";

const {categories, message} = defineProps<{ categories: ICategory[], message?: string }>()
</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories">
        <div class="px-5 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.create')"
                      class="pt-2.5 pb-1.5 px-4 bg-primary text-white rounded-t-md">
                    Create category
                </Link>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-b-lg mb-8">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3" scope="col">
                            Icon
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Title
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Number of products
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Created By
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Last Update
                        </th>
                        <th class="px-6 py-3" scope="col">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="category in categories" :key="category.id" class="bg-white border-b">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">
                            <img :alt="`${category.title}icon`" :src="category.icon" class="h-5 w-5"/>
                        </th>
                        <td class="px-6 py-4">
                            <Link :href="route('admin.categories.show', {category: category.slug})">
                                {{ category.title }}
                            </Link>
                        </td>
                        <td class="px-6 py-4 pl-20">
                            0
                        </td>
                        <td class="px-6 py-4">
                            {{ category.created_by }}
                        </td>
                        <td class="px-6 py-4">
                            {{ category.updated_at }}
                        </td>
                        <td class="px-6 py-4">
                            <Link :href="route('admin.categories.edit', {category: category.slug})"
                                  class="font-medium text-blue-600 ">
                                Edit
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <flash-message :message="message"/>
    </admin-layout>
</template>
