import {ICategoryEssentials} from "@/types/ICategoryEssentials";
import {IProductCardEssentials} from "@/types/IProductCardEssentials";

export interface ICategoryEssentialsWithProductCards extends ICategoryEssentials{
    readonly products: IProductCardEssentials[];
}
