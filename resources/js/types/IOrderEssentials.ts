export interface IOrderEssentials {
    slug: string;
    title: string;
    thumbnail: string;
    dough_type: DoughTypeEnum;
    diameter: PizzaDiameterEnum;
}

export enum DoughTypeEnum {
    Traditional = 'Традиционное',
    Thin = 'Тонкое'
}

export enum PizzaDiameterEnum {
    Small = '20',
    Medium = '28',
    Large = '33'
}
