import {boolean, number, object, string} from "yup";

export default function useProduct() {
    const productSchema = object({
        title: string().min(3).required(),
        banner: string().min(2).max(5).nullable(),
        category_id: number().positive().required(),
        description: string().min(50).required(),
        ingredients: string().min(20).required(),
        is_for_sale: boolean().required(),
        price: number().positive().required(),
        sale_price: number().nullable().positive(),
        priority: number().positive().required(),
    });

    return {productSchema}
}
