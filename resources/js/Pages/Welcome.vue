<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import ProductsGrid from "@/Components/ProductsGrid.vue";
import FlameIcon from "@/Components/Icons/FlameIcon.vue";
import ScrollCard from "@/Components/ScrollCard.vue";
import SendIcon from "@/Components/Icons/SendIcon.vue";
import LocationIcon from "@/Components/Icons/LocationIcon.vue";
import type {ICategoryEssentialsWithProductCards} from "@/types/ICategoryEssentialsWithProductCards";
import type {IAuthData} from "@/types/IAuthData";
import type {IProductDetails} from "@/types/IProductDetails";
import {onMounted, ref, watchEffect} from "vue";
import ProductModal from "@/Components/ProductModal.vue";
import type {IProductCardEssentials} from "@/types/IProductCardEssentials";
import type {IOrderEssentials} from "@/types/IOrderEssentials";


const props = defineProps<{
    categories: ICategoryEssentialsWithProductCards[],
    auth: IAuthData,
    selectedProduct?: IProductDetails,
}>()

const {categories, auth} = props

const selectedProductThumbnail = ref('')
const productModal = ref<InstanceType<typeof ProductModal> | null>(null)
const openProductModal = (product: IProductCardEssentials) => {
    selectedProductThumbnail.value = product.thumbnail

    router.reload({
        data: {
            p: product.slug
        },
    })
}

const mainLayout = ref<InstanceType<typeof MainLayout> | null>(null)
const isProductSelected = ref<boolean>(!!Object.keys(props.selectedProduct).length)

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
    }
}

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

watchEffect(() => document.body.style.overflow = isProductSelected.value ? 'hidden' : 'auto')
</script>

<template>
    <Head><title>Home</title></Head>

    <main-layout ref="mainLayout" :class="{'blur-lg overflow-hidden': isProductSelected}" :user="auth.user">
        <div class="bg-gray-bg py-[30px]">
            <div class="lg:mb-6 mb-5 sm:mx-auto sm:container mx-5">
                <ul :class="[$style['scrollbar-thin']]"
                    class="lg:gap-[30px] space-x-3 lg:space-x-0 flex lg:grid lg:grid-cols-8 overflow-auto pb-[6px]">
                    <li>
                        <a class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-full lg:h-[104px] h-10 bg-white text-red-bg rounded-xl lg:text-lg text-sm"
                           href="#">
                            <flame-icon class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0"/>
                            Акции
                        </a>
                    </li>
                    <li v-for="category in categories">
                        <Link
                            :href="route('products')"
                            class="flex lg:flex-col items-center py-5 lg:px-0 px-3 lg:w-full lg:h-[104px] h-10 bg-white rounded-xl lg:text-lg text-sm">
                            <div class="lg:h-8 lg:w-8 h-6 w-6 lg:mb-2 mr-2 lg:mr-0">
                                <img :alt="`${category.title} icon`" :src="category.icon">
                            </div>
                            {{ category.title }}
                        </Link>
                    </li>
                </ul>
            </div>

            <div class="sm:mx-auto sm:container mx-5 ">
                <ul :class="[$style['scrollbar-thin']]"
                    class="lg:grid lg:grid-cols-4 lg:gap-[30px] space-x-5 lg:space-x-0 flex overflow-auto pb-[6px]">
                    <li>
                        <scroll-card caption="3 средние пиццы от 999 рублей"
                                     class="h-80 w-[280px] lg:h-[340px] lg:w-full"
                                     image="/images/poster_1.png"/>
                    </li>
                    <li>
                        <scroll-card caption="Кэшбек 10% на самовывоз (доставка)"
                                     class="h-80 w-[280px] lg:h-[340px] lg:w-full"
                                     image="/images/poster_2.png"/>
                    </li>
                    <li>
                        <scroll-card caption="3 средние пиццы от 999 рублей"
                                     class="h-80 w-[280px] lg:h-[340px] lg:w-full"
                                     image="/images/poster_1.png"/>
                    </li>
                    <li>
                        <scroll-card caption="Кэшбек 10% на самовывоз (доставка)"
                                     class="h-80 w-[280px] lg:h-[340px] lg:w-full"
                                     image="/images/poster_2.png"/>
                    </li>
                </ul>

            </div>

            <div
                class="mt-6 sm:mx-auto sm:container mx-5 flex items-center justify-between sm:flex-row flex-col bg-white py-4 px-8 sm:p-5 rounded-md border border-gray-100">
                <div class="sm:font-normal font-semibold sm:mb-0 mb-4">Проверить адрес доставки</div>
                <form class="flex grow ml-8 w-full sm:w-auto relative" @submit.prevent>
                    <div class="relative grow">
                        <location-icon class="absolute left-3 inset-y-[14px]"/>
                        <input
                            class="text-sm md:text-base rounded-md border border-gray-200 md:py-[13px] py-[11px] px-10 placeholder-gray-400 focus:border-gray-300 focus:outline-none w-full"
                            placeholder="Адрес" type="text">
                    </div>
                    <button
                        class="md:ml-5 bg-primary rounded-md md:py-[13px] md:px-8 p-[14px] sm:static absolute right-0"
                        type="submit">
                        <span class="md:inline hidden text-white">Проверить</span>
                        <send-icon class="md:hidden"/>
                    </button>
                </form>
            </div>

            <div class="sm:container sm:mx-auto mx-5 mt-[30px] space-y-[46px]">
                <div v-for="category in categories">
                    <products-grid :category="category" @productChosen="openProductModal"/>
                </div>
            </div>

        </div>
    </main-layout>

    <product-modal ref="productModal" :product="selectedProduct as IProductDetails"/>
</template>

<style module>
@media only screen and (min-width: 768px) {
    .scrollbar-thin::-webkit-scrollbar {
        height: 7px;
    }

    /* Track */
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    /* Handle */
    .scrollbar-thin::-webkit-scrollbar-thumb {
        border-radius: 10px;
        @apply bg-primary;
    }

    /* Handle on hover */
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        @apply bg-orange-600;
    }
}

</style>
