export interface IProductCardEssentials{
    readonly id: number;
    readonly title: string;
    readonly slug: string;
    readonly ingredients: string;
    readonly price: number;
    readonly sale_price: number | null;
    readonly thumbnail: string;
    readonly banner: string | null;
}
