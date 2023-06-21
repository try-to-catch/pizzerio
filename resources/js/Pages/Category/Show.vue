<script lang="ts" setup>
import {Head, router} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import ProductsGrid from "@/Components/ProductsGrid.vue";
import type {IProductDetails} from "@/types/IProductDetails";
import ProductModal from "@/Components/ProductModal.vue";
import type {IProductCardEssentials} from "@/types/IProductCardEssentials";
import {computed, onMounted, ref} from "vue";
import {IOrderEssentials} from "@/types/IOrderEssentials";
import type {ICategoryEssentials} from "@/types/ICategoryEssentials";
import type {IPagination} from "@/types/IPagination";
import {ICategoryEssentialsWithProductCards} from "@/types/ICategoryEssentialsWithProductCards";
import DefaultPagination from "@/Components/DefaultPagination.vue";

interface IProductPagination extends IPagination {
    data: IProductCardEssentials[];
}

interface ICategoryWithProductPagination extends ICategoryEssentials {
    products: IProductPagination;
}

const props = defineProps<{
    category: ICategoryWithProductPagination,
    selectedProduct?: IProductDetails,
}>()

const {category, auth} = props

const productModal = ref<InstanceType<typeof ProductModal> | null>(null)
const isProductSelected = ref<boolean>(!!Object.keys(props.selectedProduct).length)
const mainLayout = ref<InstanceType<typeof MainLayout> | null>(null)

onMounted(() => {
    if (isProductSelected.value) {
        openModal(props.selectedProduct!)
    }
})

router.on('success', () => {
    isProductSelected.value = !!Object.keys(props.selectedProduct).length

    if (isProductSelected.value) {
        openModal(props.selectedProduct!)
    }
})

const openProductModal = (product: IProductCardEssentials) => {
    router.reload({
        data: {
            p: product.slug
        },
    })
}

const openModal = async (product: IProductDetails) => {
    const modalResult: null | IOrderEssentials = await productModal.value?.open(product)
    isProductSelected.value = false

    if (!modalResult) {
        const newUrl = window.location.href.split('?')[0]
        window.history.pushState({path: newUrl}, '', newUrl)

        isProductSelected.value = false
    }

    if (modalResult) {
        mainLayout.value?.cartInstance?.addToCart(modalResult)
        mainLayout.value?.displayMessage('Товар добавлен в корзину')
    }
}

const formattedCategory = computed(() => {
    const formattedCategory = {...category}

    if ("data" in formattedCategory.products) {
        formattedCategory.products = formattedCategory.products.data.map((product) => {
            return {
                id: product.id,
                title: product.title,
                slug: product.slug,
                ingredients: product.ingredients,
                price: product.price,
                sale_price: product.sale_price,
                thumbnail: product.thumbnail,
                banner: product.banner,
            } as IProductCardEssentials
        })
    }
    return formattedCategory
})

</script>

<template>
    <Head><title>{{ category.title }}</title></Head>

    <main-layout>
        <div class="bg-gray-bg">
            <div class="bg-gray-350">
                <div class="sm:container sm:mx-auto mx-5">
                    <products-grid :category="formattedCategory as ICategoryEssentialsWithProductCards" class="py-[30px]" @productChosen="openProductModal"/>

                    <default-pagination :links="category.products.links" class="self-center sm:py-5 py-3 flex justify-center"/>
                </div>
            </div>
        </div>
    </main-layout>

    <product-modal ref="productModal" :product="selectedProduct as IProductDetails"/>
</template>

