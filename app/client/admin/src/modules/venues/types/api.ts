import type { PaginationObject } from '@starter-core/dash-ui/src/components';

export interface GetVenueResponse {
  name: string;
  address: string;
  id: number;
  owner_id: number;
  venue_type_id: number;
  updated_at: string;
}

export interface VenuesTableResponse {
  data: GetVenueResponse[];
  pagination: PaginationObject;
}

export type AuthUser = Omit<GetVenueResponse, 'updated_at'>;
