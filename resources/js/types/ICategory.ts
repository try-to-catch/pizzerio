import {ICategoryEssentials} from "@/types/ICategoryEssentials";

export interface ICategory extends ICategoryEssentials{
    number_of_related_products: number;
    created_by: string;
    created_at: string;
    updated_at: string;
}
