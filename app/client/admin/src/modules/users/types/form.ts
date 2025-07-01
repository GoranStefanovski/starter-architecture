export interface UserFormItem {
  id?: number;
  email?: string;
  first_name?: string;
  last_name?: string;
  phone_number?: string;
  role?: number;
  is_disabled?: boolean;
  password?: string;
  password_confirmation?: string;
  username?: string| null;
  artist_tag?: string| null;
  bio?: string| null;
  city_from?: string| null;
  country_from?: string| null;
  instagram_link?: string| null;
  instagram_video?: string| null;
  facebook_link?: string| null;
  facebook_video?: string| null;
  soundcloud_link?: string| null;
  soundcloud_track?: string| null;
  spotify_link?: string| null;
  spotify_track?: string| null;
  youtube_link?: string| null;
  youtube_video?: string| null;
  contact_phone?: string| null;
  contact_email?: string| null;
}

export type UserMyProfileForm = UserFormItem;

export interface UpdatePasswordForm {
  current_password: string;
  password: string;
  password_confirmation: string;
}
