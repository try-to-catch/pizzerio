<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import {useField} from "vee-validate"
import {mixed, string} from 'yup'
import {reactive, Ref} from "vue";


const {errorMessage: titleError, value: titleValue} = useField<string>('title', string().required().min(3))
const {errorMessage: iconError, value: iconValue} = useField<File>('title', mixed().required())

interface NewCategory {
    title: Ref<string>,
    icon: Ref<null | File>
}

const form = reactive<NewCategory>({
    title: titleValue,
    icon: iconValue
})

const store = async () => {
    console.log(form);
}
</script>

<template>
    <Head><title>Categories</title></Head>
    <admin-layout title="Categories - Create">
        <div class="px-5 pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.categories.index')" class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <form class="relative overflow-x-auto shadow-md sm:rounded-b-lg px-5 py-3 space-y-4 bg-white"
                  @submit.prevent="store">
                <div class="space-x-5">
                    <label for="title">Title</label>
                    <input id="title" v-model="titleValue" :class="{'border border-red-700': titleError }"
                           class="rounded-md" name="title" required
                           type="text"/>
                    <span v-if="titleError" class="text-sm text-red-500">{{ titleError }}</span>
                </div>

                <div class="space-x-5">
                    <label for="icon">Icon</label>
                    <input id="icon" :class="{'border border-red-700': iconError }" accept="image/png" name="icon"
                           required
                           type="file" @input="iconValue = $event.target.files[0]"/>
                    <span v-if="iconError" class="text-sm text-red-500">{{ iconError }}</span>
                </div>

                <button class="pt-2.5 pb-1.5 px-4 bg-primary text-white rounded-md" type="submit">Create</button>
            </form>
        </div>
    </admin-layout>
</template>
