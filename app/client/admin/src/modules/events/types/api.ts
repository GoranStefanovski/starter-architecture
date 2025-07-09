import type { PaginationObject } from '@starter-core/dash-ui/src/components';

export interface GetEventResponse {
  id?: number;
  user_id: number;
  venue_id?: number | undefined;
  name: string;
  description?: string;
  country: string;
  city: string;
  address?: string;
  lng: number;
  lat: number;
  event_start: Date;
  event_end: Date;
  tickets: [];
  genreIds: [];
  is_boosted?: boolean;
  is_active?: boolean;
  images: EventImages;
}

export interface GetEventDataRowResponse {
  id: number;
  user_id: number;
  name: string;
  address: string;
  event_start: Date;
  is_active?: boolean;
  is_boosted?: boolean;
}

export interface GetMusicGenreResponse {
  id: number;
  name: string;
}

export interface GetTicketTypesResponse {
  // label: string;
  id: string;
  name: string;
}

export interface EventsTableResponse {
  data: GetEventDataRowResponse[];
  pagination: PaginationObject;
}

export interface MusicGenreResponse {
  data: GetMusicGenreResponse[];
}

export interface TicketTypesResponse {
  types: GetTicketTypesResponse[];
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

export type AuthUser = Omit<GetEventResponse, 'updated_at'>;
