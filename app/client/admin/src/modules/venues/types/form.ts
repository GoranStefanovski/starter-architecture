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
}

export type UserMyProfileForm = Pick<UserFormItem, 'name' | 'address' | 'bio'>;

export interface UpdatePasswordForm {
  current_password: string;
  password: string;
  password_confirmation: string;
}
