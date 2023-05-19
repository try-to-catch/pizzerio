<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import {useField} from "vee-validate"
import {string} from 'yup'
import {ICategory} from "@/types/ICategory";
import {reactive} from "vue";

const {category} = defineProps<{ category: ICategory }>()

const {
    errorMessage: titleError,
    value: titleValue,
    setErrors: setTitleErrors
} = useField<string>('title', string().min(3))

titleValue.value = category.title;

const {errorMessage: iconError, value: iconValue} = useField<null | File>('icon')

interface INewCategory {
    title: string,
    icon: null | File
}

const form = reactive<INewCategory>({
    title: '',
    icon: null,
})

const onError = (val: { title?: string }): void => {
    if (val.title) {
        setTitleErrors(val.title)
    }
}
const update = async () => {
    form.title = titleValue.value
    form.icon = iconValue.value
    router.post(`/admin/categories/${category.slug}`, {_method: 'patch', ...form}, {onError})
}
</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories - Edit">
        <div class="xl:px-40 lg:px-28 md:px-16 sm:px-4 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.index')"
                      class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <form class="relative overflow-x-auto shadow-md sm:rounded-b-lg px-5 py-3 space-y-4 bg-white"
                  @submit.prevent="update">
                <div class="space-x-5">
                    <label for="title">Title</label>
                    <input id="title" v-model="titleValue"
                           :class="{'border border-red-700': titleError }"
                           class="rounded-md" name="title"
                           type="text"/>
                    <span v-if="titleError" class="text-sm text-red-500">
                        {{ titleError }}
                    </span>
                </div>

                <div class="sm:space-y-0 space-y-4 sm:flex sm:items-center">
                    <div class="flex items-center space-x-5">
                        <label for="icon">Current Icon</label>
                        <img :alt="category.title" :src="category.icon" class="h-10 w-10"/>
                    </div>

                    <div class="border-r mx-4 border-gray-800 h-3 sm:block hidden"></div>
                    <div class="flex items-center space-x-5">
                        <label for="icon">New Icon</label>
                        <input id="icon" :class="{'border border-red-700': iconError }"
                               accept="image/png"
                               class="w-3/5 py-2 px-3 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                               name="icon"
                               type="file" @input="iconValue = $event.target.files[0]"/>
                    </div>

                    <span v-if="iconError" class="text-sm text-red-500">
                        {{ iconError }}
                    </span>
                </div>

                <button class="pt-2.5 pb-1.5 px-4 bg-orange-400 text-white rounded-md"
                        type="submit">
                    Update
                </button>
            </form>
        </div>
    </admin-layout>
</template>
