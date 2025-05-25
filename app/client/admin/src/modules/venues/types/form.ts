export interface UserFormItem {
  id?: number;
  name?: string;
  owner_id?: number;
  address?: string;
  venue_type_id?: number;
}

export type UserMyProfileForm = Pick<UserFormItem, 'name' | 'address'>;

export interface UpdatePasswordForm {
  current_password: string;
  password: string;
  password_confirmation: string;
}
