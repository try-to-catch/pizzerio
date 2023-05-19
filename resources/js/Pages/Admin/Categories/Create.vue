<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import {useField} from "vee-validate"
import {mixed, string} from 'yup'


const {errorMessage: titleError, value: titleValue} = useField<string>('title', string().required().min(3))
const {errorMessage: iconError, value: iconValue} = useField<null | File>('icon', mixed().required())

interface NewCategory {
    title: string,
    icon: null | File
}

const form = useForm<NewCategory>({
    title: '',
    icon: null
})

const store = async () => {
    form.title = titleValue.value
    form.icon = iconValue.value
    form.post('/admin/categories')
}
</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories - Create">
        <div class="px-5 xl:px-40 lg:px-28 md:px-16 sm:px-4 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.index')"
                      class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <form class="relative overflow-x-auto shadow-md sm:rounded-b-lg px-5 py-3 space-y-4 bg-white"
                  @submit.prevent="store">
                <div class="space-x-5">
                    <label for="title">Title</label>
                    <input id="title" v-model="titleValue"
                           :class="{'border border-red-700': titleError || form.errors.title }"
                           class="rounded-md" name="title" required
                           type="text"/>
                    <span v-if="titleError|| form.errors.title" class="text-sm text-red-500">{{
                            titleError
                        }} {{ form.errors.title }}</span>
                </div>

                <div class="space-x-5">
                    <label for="icon">Icon</label>
                    <input id="icon" :class="{'border border-red-700': iconError || form.errors.icon }"
                           accept="image/png" class="py-2 px-3 w-1/3 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                           name="icon"
                           required
                           type="file" @input="iconValue = $event.target.files[0]"/>
                    <span v-if="iconError || form.errors.icon" class="text-sm text-red-500">{{
                            iconError
                        }} {{ form.errors.icon }}</span>
                </div>

                <button :disabled="form.processing" class="pt-2.5 pb-1.5 px-4 bg-primary text-white rounded-md"
                        type="submit">Create
                </button>
            </form>
        </div>
    </admin-layout>
</template>
