import {IProductCardEssentials} from "@/types/IProductCardEssentials";

export interface IProductCard extends IProductCardEssentials {
    readonly sale_price: number | null;
    readonly priority: number;
    readonly banner: string | null;
}
