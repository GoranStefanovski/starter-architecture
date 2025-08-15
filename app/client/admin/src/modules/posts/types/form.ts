export interface PostFormItem {
  id?: number;
  user_id: number;
  venue_id?: number | null;
  name: string;
  description?: string;
  is_boosted?: boolean;
  is_active?: boolean;
  images: [banner: {}, card: {}, thumbnail: {}];
}

