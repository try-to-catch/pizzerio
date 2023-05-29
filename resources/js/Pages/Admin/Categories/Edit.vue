<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import {object, string} from 'yup'
import type {ICategory} from "@/types/ICategory";
import type {ICategoryFormData} from "@/types/ICategoryFormData";
import DefaultAdminForm from "@/Components/Form/DefaultAdminForm.vue";
import InputField from "@/Components/Form/InputField.vue";
import {computed} from "vue";
import OrangeButton from "@/Components/Form/OrangeButton.vue";
import FileInput from "@/Components/Form/FileInput.vue";

const {category} = defineProps<{ category: ICategory }>()

const categorySchema = object({
    title: string().min(3),
})

const form = useForm<ICategoryFormData>({
    title: category.title,
    icon: null,
    _method: 'patch'
})

const update = async () => {
    const errors = await categorySchema.validate(form, {abortEarly: false}).catch((errors) => {
        errors.inner.forEach(error => {
            const splitError = error.message.split(' ')
            splitError.shift()

            const formattedMessage = `This ${splitError.join(' ')}`
            form.setError(error.path, formattedMessage)
        })
    });

    if (!errors) {
        form.post(`/admin/categories/${category.slug}`)

    }
}


const isDisabled = computed((): boolean => Boolean(form.processing || form.errors.icon))

const loadFile = ($event) => form.icon = $event.target.files[0]
const clearFormErrors = () => form.clearErrors()

</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories - Edit">
        <div class="xl:w-[900px] lg:w-[720px] md:w-[640px] sm:w-auto sm:mx-5 mx-3 md:mx-auto pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.index')"
                      class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <default-admin-form class="mb-8" @submit.prevent="update">
                <input-field id="title" v-model="form.title" :errors="form.errors.title" label="Title"
                             @input="clearFormErrors"/>

                <file-input :errors="form.errors.icon" label="Icon" @input="loadFile"/>

                <orange-button :disabled="isDisabled">Update</orange-button>
            </default-admin-form>
        </div>
    </admin-layout>
</template>
