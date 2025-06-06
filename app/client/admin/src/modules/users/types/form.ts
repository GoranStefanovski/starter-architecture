export interface UserFormItem {
  id?: number;
  email?: string;
  first_name?: string;
  last_name?: string;
  role?: number;
  is_disabled?: boolean;
  password?: string;
  password_confirmation?: string;
  paid_leaves_max?: number;
  paid_leaves_left?: number;
  country?: number;
  is_office_based?: boolean;
}
