import type {IProduct} from "@/types/IProduct";

export interface IExtendedProduct extends IProduct {
    ingredients: string;
    description: string;
    priority: number;
    created_at: string;
    sale_price?: number;
    banner?: string;
}
