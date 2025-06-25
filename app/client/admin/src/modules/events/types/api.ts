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
  data: GetEventResponse[];
  pagination: PaginationObject;
}

export interface MusicGenreResponse {
  data: GetMusicGenreResponse[];
}

export interface TicketTypesResponse {
  types: GetTicketTypesResponse[];
}

export type AuthUser = Omit<GetEventResponse, 'updated_at'>;
