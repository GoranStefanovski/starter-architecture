export interface UserFormItem {
  id?: number;
  user_id: number;
  venue_id?: number | null;
  name: string;
  description?: string;
  country: string;
  city: string;
  address?: string | null;
  lng: number;
  lat: number;
  event_start: Date;
  event_end: Date;
  tickets: Array<TicketFormItem>[];
  genreIds: [];
}

export interface TicketFormItem {
  id?: number;
  event_id: number;
  price: number;
  quantity: number;
  sale_start: Date;
  sale_end: Date;
  type: any;
}
