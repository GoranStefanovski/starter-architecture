export interface UserFormItem {
  id?: number | undefined;
  user_id: number;
  venue_id?: number | undefined;
  name: string;
  description?: string | undefined;
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

export type UserMyProfileForm = Pick<UserFormItem, 'name' | 'address' | 'description'>;

export interface UpdatePasswordForm {
  current_password: string;
  password: string;
  password_confirmation: string;
}
