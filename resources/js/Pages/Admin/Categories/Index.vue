<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3"
</script>

<template>
    <admin-layout title="Categories">
        <div class="px-5 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.create')" class="pt-2.5 pb-1.5 px-4 bg-primary text-white rounded-t-md">
                    Create category
                </Link>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-b-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Icon
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Number of products
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Last update
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <img src="/storage/images/categories/pizza.png" class="h-5 w-5" alt="pizza-icon"/>
                        </th>
                        <td class="px-6 py-4">
                            Pizza
                        </td>
                        <td class="px-6 py-4">
                            5
                        </td>
                        <td class="px-6 py-4">
                            15.02.2023
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600">Edit</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </admin-layout>
</template>
