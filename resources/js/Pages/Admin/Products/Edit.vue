<script lang="ts" setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import useProduct from "@/composables/admin/product";
import DefaultAdminForm from "@/Components/Form/DefaultAdminForm.vue";
import InputField from "@/Components/Form/InputField.vue";
import OrangeButton from "@/Components/Form/OrangeButton.vue";
import type {IProductFormData} from "@/types/IProductFormData";
import {computed, ref, watchEffect} from "vue";
import FileInput from "@/Components/Form/FileInput.vue";
import CheckBox from "@/Components/Form/ToggleCheckBox.vue";
import DecimalInput from "@/Components/Form/DecimalInput.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import SelectBox from "@/Components/Form/SelectBox.vue";

interface IProductFormDataExtended extends IProductFormData {
    thumbnail?: null | File;
    slug: string;
}

const {categories, product} = defineProps<{
    categories: { id: number, title: string }[];
    product: IProductFormDataExtended;
}>()


const form = useForm<IProductFormDataExtended>({...product, thumbnail: null, _method: "patch"})

const {productSchema} = useProduct()
const store = async () => {
    await productSchema.validate(form, {abortEarly: false}).catch((errors) => {
        errors.inner.forEach(error => {
            const splitError = error.message.split(' ')
            splitError.shift()

            const formattedMessage = `This ${splitError.join(' ')}`
            form.setError(error.path, formattedMessage)
        })
    });

    if (!form.hasErrors) {
        form.post(`/admin/products/${product.slug}`)
    }
}

const isDisabled = computed((): boolean => {
    return Boolean(form.processing || form.hasErrors)
})

const preparedCategories = computed(() => {
    return categories.map(category => {
        return {label: category.title, value: category.id}
    })
})

const loadFile = ($event) => form.thumbnail = $event.target.files[0]
const clearFieldError = (field) => form.clearErrors(field)

const hasDiscountPrice = ref<boolean>(!!product.sale_price)

watchEffect(() => {
    if (!hasDiscountPrice.value) {
        form.sale_price = null
    }
})

const hasBanner = ref<boolean>(!!product.banner)

watchEffect(() => {
    if (!hasBanner.value) {
        form.banner = null
    }
})
</script>

<template>
    <Head><title>Products</title></Head>
    <admin-layout title="Products - Edit">
        <div class="xl:w-[900px] lg:w-[720px] md:w-[640px] sm:w-auto sm:mx-5 mx-3 md:mx-auto pt-10">
            <div class="flex justify-end">
                <Link :href="route('admin.products.show', {product: product.slug})"
                      class="pt-2.5 pb-1.5 px-4 bg-gray-300 text-white rounded-t-md">
                    Go back
                </Link>
            </div>

            <default-admin-form class="mb-8" @submit.prevent="store">
                <input-field id="title" v-model="form.title" :errors="form.errors.title" :required="true"
                             label="Title"
                             @input="clearFieldError('title')"/>

                <input-field id="ingredients" v-model="form.ingredients" :errors="form.errors.ingredients"
                             :required="true"
                             label="Ingredients"
                             @input="clearFieldError('ingredients')"/>

                <text-area id="description" v-model="form.description" :errors="form.errors.description"
                           :required="true"
                           label="Description" @input="clearFieldError('description')"/>

                <select-box id="category_id" v-model="form.category_id" :options="preparedCategories" :required="true"
                            label="Relate to" start-option-label="Choose the category"
                            @input="clearFieldError('category_id')"/>

                <div :class="{'sm:grid-cols-2': hasDiscountPrice}" class="grid gap-4">
                    <decimal-input id="price" v-model="form.price" :errors="form.errors.price"
                                   :required="true" label="Price"
                                   @input="clearFieldError('price')"/>

                    <decimal-input v-if="hasDiscountPrice" id="sale_price" v-model="form.sale_price"
                                   :errors="form.errors.sale_price"
                                   :required="true"
                                   label="Discount price"
                                   @input="clearFieldError('sale_price')"/>
                </div>

                <div :class="{'sm:grid-cols-2': hasBanner}" class="grid gap-4">
                    <input-field id="priority" v-model="form.priority" :errors="form.errors.priority"
                                 :required="true" label="Priority"
                                 type="number" @input="clearFieldError('priority')"/>

                    <input-field v-if="hasBanner" id="banner" v-model="form.banner" :errors="form.errors.banner"
                                 :required="true"
                                 label="Banner text"
                                 @input="clearFieldError('banner')"/>
                </div>


                <file-input id="thumbnail" :errors="form.errors.thumbnail" accept="image/*"
                            label="Thumbnail" @change="clearFieldError('thumbnail')"
                            @input="loadFile"/>

                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <check-box v-model="form.is_for_sale" label="Is product for sale?"/>
                    <check-box v-model="hasDiscountPrice" label="Has discount price?"/>
                    <check-box v-model="hasBanner" label="Has banner?"/>
                </div>
                <orange-button :disabled="isDisabled">Update</orange-button>
            </default-admin-form>
        </div>
    </admin-layout>
</template>
