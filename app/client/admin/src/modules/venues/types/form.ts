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
  logo: [];
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

export type UserMyProfileForm = Pick<UserFormItem, 'name' | 'address' | 'bio'>;

export interface UpdatePasswordForm {
  current_password: string;
  password: string;
  password_confirmation: string;
}
