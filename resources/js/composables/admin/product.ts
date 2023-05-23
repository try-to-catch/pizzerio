import {boolean, number, object, string} from "yup";

export default function useProduct() {
    const productSchema = object({
        title: string().min(3),
        banner: string().min(2).nullable(),
        categoryId: number().positive(),
        description: string().min(50),
        ingredients: string().min(20),
        isForSale: boolean(),
        price: number().positive(),
        salePrice: number().nullable().positive(),
        priority: number().positive(),
    });

    return {productSchema}
}
