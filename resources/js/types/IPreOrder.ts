export interface IPreOrder {
    customer: ICustomerData;
    destination: IDestinationData;
    comment: string | null;
}

export interface ICustomerData {
    name: string;
    phone: string;
    email: string;
}

export interface IDestinationData {
    street: string;
    house: string | null;
    entrance: string | null;
    floor: string | null;
    apartment: string | null;
    intercom: string | null;
}
