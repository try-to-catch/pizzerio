<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link} from "@inertiajs/vue3"
import {ICategory} from "@/types/ICategory";
import {onMounted, ref} from "vue";

const {categories, message} = defineProps<{ categories: ICategory[], message?: string }>()
const isMessageVisible = ref(true)

onMounted(() => {
    setTimeout(() => isMessageVisible.value = false, 10000)
})

const hiddeMessage = () => isMessageVisible.value = false
</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories">
        <div class="px-5 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.products.create')"
                      class="pt-2.5 pb-1.5 px-4 bg-primary text-white rounded-t-md">
                    Create product
                </Link>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-b-lg">
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

        <transition name="flash-message">
            <div v-if="isMessageVisible && message" class="absolute top-2 w-full flex justify-center"
                 @click="hiddeMessage">
                <div class="min-w-[240px] bg-gray-400 shadow-xl text-white h-12  py-3 px-5 rounded-md text-center">
                    {{ message }}
                </div>
            </div>
        </transition>
    </admin-layout>
</template>


<style>
.flash-message-enter-active,
.flash-message-leave-active {
    opacity: 1;
    transition: opacity 0.3s ease-in-out;
}

.flash-message-enter-from,
.flash-message-leave-to {
    opacity: 0;
}
</style>
