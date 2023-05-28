export interface IProduct {
    readonly id: number;
    readonly slug: string;
    title: string;
    price: number;
    is_for_sale: boolean;
    thumbnail: string;
    readonly updated_at: string;
    readonly category_title: string;
    readonly category_slug: string;
    readonly created_by?: string;
}
