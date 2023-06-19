// I'm practising writing composable with OOP approach using Copilot

import type {IOrderEssentials} from "@/types/IOrderEssentials";
import {reactive} from "vue";
import {IOrderEssentialsWithQuantity} from "@/types/IOrderEssentialsWithQuantity";

export default class UseCart {

    public constructor() {
        // when we create new instance of this class, we want to load cart from local storage
        this.loadCart()
    }

    public cart = reactive<IOrderEssentialsWithQuantity[]>([])

    protected loadCart = () => {
        // load cart from local storage
        return this.cart.push(...JSON.parse(localStorage.getItem('cart') || '[]'))
    }
    protected saveCart = () => {
        // save cart to local storage
        localStorage.setItem('cart', JSON.stringify(this.cart))
    }


    public addToCart = (product: IOrderEssentials) => {
        // check if product already exists in cart
        // if not, add it to cart
        // if it exists, increment quantity
        // save cart to local storage
        // return cart
        const exists = this.cart.find(item => item.slug === product.slug)

        if (!exists) {
            //save product in new variable and add quantity property
            const productWithQuantity = {...product, quantity: 1}

            this.cart.push(productWithQuantity)
            this.saveCart()

            return productWithQuantity
        }

        // in this case we have already product in cart, and we need to increment quantity
        if (exists) {
            exists.quantity++
            this.saveCart()

            return exists
        }
    }

    public removeFromCart = (product: IOrderEssentialsWithQuantity) => {
        // remove product from cart
        // save cart to local storage
        // return cart
        const index = this.cart.findIndex((item) => item.slug === product.slug);

        if (index !== -1) {
            this.cart.splice(index, 1);
            this.saveCart();
        }

        return this.cart
    }

    //this method is increasing quantity of product in cart if second parameter is true in other case it's decreasing
    public changeQuantity = (product: IOrderEssentialsWithQuantity, increase: boolean = true) => {
        const exists = this.cart.find(item => item.slug === product.slug)

        if (exists) {
            increase ? exists.quantity++ : exists.quantity--
            this.saveCart()
        }

        return this.cart
    }
}
