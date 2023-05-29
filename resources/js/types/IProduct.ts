export interface IProduct {
    readonly id: number;
    readonly slug: string;
    title: string;
    price: number;
    is_for_sale: boolean;
    thumbnail: string;
    readonly updated_at: string;
    readonly category: ICategory;
    readonly user?: IUserWithEmail;
}

interface IUserWithEmail {
    readonly email: string;
}

interface ICategory {
    readonly title: string;
    readonly slug: string;
}
