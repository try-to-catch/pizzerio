import type {IOrderEssentials} from "@/types/IOrderEssentials";

export interface IOrderEssentialsWithQuantity extends IOrderEssentials {
    quantity: number;
}
