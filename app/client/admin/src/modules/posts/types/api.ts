import type { PaginationObject } from '@starter-core/dash-ui/src/components';

export interface GetPostResponse {
  id?: number;
  user_id: number;
  venue_id?: number | undefined;
  name: string;
  description?: string;
  is_boosted?: boolean;
  is_active?: boolean;
  post_slot?: string;
}

export interface GetPostDataRowResponse {
  id: number;
  user_id: number;
  name: string;
  is_active?: boolean;
  is_boosted?: boolean;
  post_slot?: string;
}


export interface PostsTableResponse {
  data: GetPostDataRowResponse[];
  pagination: PaginationObject;
}

export interface ImageVariant {
  url: string;
  srcset: string | null;
  webp: string[] | null;
}

export interface EventImages {
  banner: ImageVariant;
  card: ImageVariant;
  thumbnail: ImageVariant;
}

export type AuthUser = Omit<GetPostResponse, 'updated_at'>;
