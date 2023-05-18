<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories - Create">
        <div class="px-5 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.index')" class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-b-lg px-5 py-3 space-y-4 bg-white">

            </div>
        </div>
    </admin-layout>
</template>
<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
</script>
