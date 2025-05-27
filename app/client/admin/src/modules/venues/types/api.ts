import type { PaginationObject } from '@starter-core/dash-ui/src/components';

export interface GetVenueResponse {
  id: number;
  user_id: number;
  name: string;
  venue_type_id: number;
  bio?: string;
  address: string;
  lng: number;
  lat: number;
  updated_at: string;
}

export interface VenuesTableResponse {
  data: GetVenueResponse[];
  pagination: PaginationObject;
}

export type AuthUser = Omit<GetVenueResponse, 'updated_at'>;
