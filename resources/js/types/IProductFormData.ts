export interface IProductFormData {
    title: string,
    price: number,
    sale_price: number | null,
    priority: number,
    ingredients: string,
    description: string,
    is_for_sale: boolean,
    banner: string | null,
    category_id: number | null,
    thumbnail: null | File,
    _method?: 'put' | 'patch'
}
