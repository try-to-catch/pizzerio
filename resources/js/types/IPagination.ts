export interface IPagination {
    current_page: number;
    data: any[];
    first_page_url: string;
    from: number;
    links: ILink[];
    last_page: number;
    last_page_url: string;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}


export interface ILink {
    url?: string | null;
    label: string;
    active: boolean;
}
