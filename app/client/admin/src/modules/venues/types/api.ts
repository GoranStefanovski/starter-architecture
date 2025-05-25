import type { PaginationObject } from '@starter-core/dash-ui/src/components';

export interface GetUserResponse {
  name: string;
  address: string;
  id: number;
  owner_id: number;
  venue_type_id: number;
  updated_at: string;
}

export interface UsersTableResponse {
  data: GetUserResponse[];
  pagination: PaginationObject;
}

export type AuthUser = Omit<GetUserResponse, 'updated_at'>;
