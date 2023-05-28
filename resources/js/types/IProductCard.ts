export interface IProductCard {
    id: number;
    title: string;
    description: string;
    price: number;
    thumbnail: string;
    status?: string | null;
}
