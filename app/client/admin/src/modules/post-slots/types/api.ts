import type { PaginationObject } from '@starter-core/dash-ui/src/components';

export interface GetPostSlotResponse {
  id?: number;
  name: string;
  is_active?: boolean;
}

export interface GetPostSlotDataRowResponse {
  id: number;
  name: string;
  is_active?: boolean;
}


export interface EventsTableResponse {
  data: GetPostSlotDataRowResponse[];
  pagination: PaginationObject;
}


export type AuthUser = Omit<GetPostSlotResponse, 'updated_at'>;
