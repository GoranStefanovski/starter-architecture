import type { PaginationObject } from '@starter-core/dash-ui/src/components';

export interface GetStoreResponse {
  id: number;
  name: string;
  slug: string;
  domain: string;
  address?: string | null;
  phone?: string | null;
  email?: string | null;
  website?: string | null;
  user_id: number;
  description?: string | null;
  is_active: boolean;
  created_at: string;
  updated_at: string;
}

export interface StoresTableResponse {
  data: GetStoreResponse[];
  pagination: PaginationObject;
}

export type ActiveStore = Omit<GetStoreResponse, 'created_at' | 'updated_at'>;
