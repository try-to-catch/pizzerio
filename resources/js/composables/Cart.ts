// I'm practising writing composable with OOP approach using Copilot

import type {IOrderEssentials} from "@/types/IOrderEssentials";
import {computed, reactive} from "vue";
import type {IOrderEssentialsWithQuantity} from "@/types/IOrderEssentialsWithQuantity";
import axios from "axios";

export default class Cart {

    public constructor() {
        // when we create new instance of this class, we want to load cart from local storage
        this.loadCart()
    }

    public cart = reactive<IOrderEssentialsWithQuantity[]>([])

    public formattedItemsCount = computed((): "9+" | number => {
        const cartItemsCount = this.cart.length

        if (cartItemsCount > 9) {
            return '9+'
        }

        return cartItemsCount
    })

    public formattedTotalPrice = computed((): string => {
        const total = this.cart.reduce((acc, item) => {
            return acc + (item.sale_price || item.price) * item.quantity
        }, 0)

        return total > 999 ? '999$+' : total + '$'
    })

    protected loadCart = () => {
        // load cart from local storage
        return this.cart.push(...JSON.parse(localStorage.getItem('cart') || '[]'))
    }
    protected saveCart = () => {
        // save cart to local storage
        localStorage.setItem('cart', JSON.stringify(this.cart))
    }


    public addToCart = async (product: IOrderEssentials) => {
        const exists = this.cart.find(item => item.slug === product.slug)

        try {
            await axios.post(route('cart.add'), {product_id: product.id});

            if (!exists) {
                const productWithQuantity = {...product, quantity: 1};

                this.cart.push(productWithQuantity);
                this.saveCart();
            }

            if (exists) {
                exists.quantity++;
                this.saveCart();
            }
        } catch (error) {
            console.error(error);
        }

        return this.cart
    }

    public remove = async (productId: number) => {
        // remove product from cart
        // save cart to local storage
        // return cart
        const index = this.cart.findIndex((item) => item.id === productId);

        try {
            await axios.delete(route('cart.remove', {productId: productId}));

            if (index !== -1) {
                this.cart.splice(index, 1);
                this.saveCart();
            }
        } catch (error) {
            console.error(error);
        }

        return this.cart
    }


    //this method is increasing quantity of product in cart if second parameter is true in other case it's decreasing
    public changeQuantity = async (productId: number, quantity: number) => {
        const exists = this.cart.find(item => item.id === productId)

        await axios.patch(route('cart.update', {productId}), {quantity})

        if (exists) {
            exists.quantity = quantity
            this.saveCart()
        }

        return this.cart
    }
}
