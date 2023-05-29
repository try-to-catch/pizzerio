<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import {mixed, object, string} from 'yup'
import type {ICategoryFormData} from "@/types/ICategoryFormData";
import DefaultAdminForm from "@/Components/Form/DefaultAdminForm.vue";
import {computed} from "vue";
import InputField from "@/Components/Form/InputField.vue";
import OrangeButton from "@/Components/Form/OrangeButton.vue";
import FileInput from "@/Components/Form/FileInput.vue";

const categorySchema = object({
    title: string().min(3).required(),
    icon: mixed().required(),
})

const form = useForm<ICategoryFormData>({
    title: '',
    icon: null
})

const store = async () => {
    await categorySchema.validate(form, {abortEarly: false}).catch((errors) => {
        errors.inner.forEach(error => {
            const splitError = error.message.split(' ')
            splitError.shift()

            const formattedMessage = `This ${splitError.join(' ')}`
            form.setError(error.path, formattedMessage)
        })
    });

    if (!form.hasErrors) {
        form.post('/admin/categories')
    }
}


const isDisabled = computed((): boolean => Boolean(form.processing || form.hasErrors))

const loadFile = ($event) => form.icon = $event.target.files[0]
const clearFormErrors = () => form.clearErrors()
</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories - Create">
        <div class="xl:w-[900px] lg:w-[720px] md:w-[640px] sm:w-auto sm:mx-5 mx-3 md:mx-auto pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.index')"
                      class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <default-admin-form class="mb-8" @submit.prevent="store">
                <input-field id="title" v-model="form.title" :errors="form.errors.title" :required="true"
                             label="Title"
                             @input="clearFormErrors"/>

                <file-input :errors="form.errors.icon" :required="true" @input="loadFile"/>

                <orange-button :disabled="isDisabled">Create</orange-button>
            </default-admin-form>
        </div>
    </admin-layout>
</template>
