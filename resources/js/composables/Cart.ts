import type {IOrderEssentials} from "@/types/IOrderEssentials";
import {computed, ref} from "vue";
import type {IOrderEssentialsWithQuantity} from "@/types/IOrderEssentialsWithQuantity";
import axios from "axios";
import {usePage} from "@inertiajs/vue3";
import {ICartGlobalData} from "@/types/ICartGlobalData";

export default class Cart {

    public count = ref(0)
    public total = ref(0)

    public constructor() {
        const cartGlobalData = usePage().props['cart'] as ICartGlobalData | undefined

        if (cartGlobalData) {
            this.count.value = cartGlobalData.count || 0
            this.total.value = cartGlobalData.total || 0
        }
    }

    public formattedItemsCount = computed((): "9+" | number => {
        return this.count.value > 9 ? '9+' : this.count.value
    })

    public formattedTotalPrice = computed((): string => {
        return this.total.value.toFixed(2) + '$'
    })

    public formattedFinalTotalPrice = computed((): string => {
        return this.total.value.toLocaleString() + '$'
    })

    public add = async (product: IOrderEssentials) => {
        return await axios.post(route('cart.add'), {product_id: product.id}).then(() => {
            this.total.value += product.sale_price ?? product.price
            this.count.value++;
        })
    }

    public remove = async (product: IOrderEssentials) => {
        return await axios.delete(route('cart.remove', {productId: product.id}))
            .then(() => {
                this.total.value -= product.sale_price ?? product.price
                this.count.value--
            })
    }

    public changeQuantity = async (product: IOrderEssentialsWithQuantity, values: IProductQuantityValues) => {
        return await axios.patch(route('cart.update', {productId: product.id}), {quantity: values.new})
            .then(() => this.changeValuesLocally(product, values))
    }

    public changeValuesLocally = (product: IOrderEssentialsWithQuantity, values: IProductQuantityValues) => {
        const quantityDiff = values.new - values.old

        this.total.value += (product.sale_price ?? product.price) * quantityDiff
        this.count.value += quantityDiff
    }

    public clear = () => {
        this.total.value = 0
        this.count.value = 0
    }
}
