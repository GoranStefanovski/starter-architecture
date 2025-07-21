import type { PaginationObject } from '@starter-core/dash-ui/src/components';

export interface GetCategoryResponse {
  id: number;
  name: string;
  slug: string;
  description?: string | null;
  is_active: boolean;
  created_at: string;
  updated_at: string;
}

export interface CategoriesTableResponse {
  data: GetCategoryResponse[];
  pagination: PaginationObject;
}

export type ActiveCategory = Omit<GetCategoryResponse, 'created_at' | 'updated_at'>;
