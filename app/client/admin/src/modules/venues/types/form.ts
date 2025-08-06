export interface UserFormItem {
  id?: number;
  user_id?: number;
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
  images: [];
  is_active: boolean;
  is_boosted: boolean;
  collaborator_id?: number;
  logo: [];
  working_hours: WorkingHour[];
}

export type UserMyProfileForm = Pick<UserFormItem, 'name' | 'address' | 'bio'>;

export interface UpdatePasswordForm {
  current_password: string;
  password: string;
  password_confirmation: string;
}
export interface WorkingHour {
  day_of_week: number;
  opens_at: WorkingHourDatePicker;
  closes_at: WorkingHourDatePicker;
  is_closed: boolean;
}
export interface WorkingHourDatePicker {
  hours: number;
  minutes: number;
}
