export interface IPreOrder {
    customer: ICustomerData;
    destination: IDestinationData;
    comment: string;
}

export interface ICustomerData {
    name: string;
    phone: string;
    email: string;
}

export interface IDestinationData {
    street: string;
    house: string;
    entrance: string;
    floor: string;
    apartment: string;
    intercom: string;
}
