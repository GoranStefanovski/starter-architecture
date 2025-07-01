import type { Permission, UserRoleId } from './permissions';
import type { PaginationObject } from '@starter-core/dash-ui/src/components';

export interface GetUserResponse {
  avatar_url: string | null;
  avatar_thumbnail: string | null;
  email: string;
  first_name: string;
  id: number;
  is_disabled: boolean;
  last_name: string;
  phone_number: string;
  permissions_array: Permission[];
  role: UserRoleId;
  updated_at: string;
  username: string | null;
  artist_tag: string | null;
  bio: string | null;
  city_from: string | null;
  country_from: string | null;
  instagram_link: string | null;
  instagram_video: string | null;
  facebook_link: string | null;
  facebook_video: string | null;
  soundcloud_link: string | null;
  soundcloud_track: string | null;
  spotify_link: string | null;
  spotify_track: string | null;
  youtube_link: string | null;
  youtube_video: string | null;
  contact_phone: string | null;
  contact_email: string | null;
}

export interface UsersTableResponse {
  data: GetUserResponse[];
  pagination: PaginationObject;
}

export type AuthUser = Omit<GetUserResponse, 'updated_at'>;
