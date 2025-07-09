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
  email: string;
  phone_number: string;
  city: string;
  country: string;
  updated_at: string;
  images: VenueImage[];
  is_active: boolean;
  logo: ImageVariant;
  working_hours: WorkingHours;
}

export interface WorkingHoursDay {
  open: boolean;
  from: string | null; // e.g., "09:00"
  to: string | null;   // e.g., "17:00"
}

export interface WorkingHours {
  monday: WorkingHoursDay;
  tuesday: WorkingHoursDay;
  wednesday: WorkingHoursDay;
  thursday: WorkingHoursDay;
  friday: WorkingHoursDay;
  saturday: WorkingHoursDay;
  sunday: WorkingHoursDay;
}

export interface GetVenueTypeResponse {
  id: number;
  name: string;
}

export interface VenuesTableResponse {
  data: GetVenueResponse[];
  pagination: PaginationObject;
}

export interface VenueTypeResponse {
  data: GetVenueTypeResponse[];
}

export interface ImageVariant {
  id: number;
  url: string;
  srcset: string | null;
  webp: string[] | null;
}

export interface VenueImage {
  id: number;
  banner: ImageVariant;
  card: ImageVariant;
  thumbnail: ImageVariant;
}

export type AuthUser = Omit<GetVenueResponse, 'updated_at'>;
