export interface CategoryFormItem {
  id?: number;              // Optional for create, required for update
  name: string;             // Category name
  slug: string;             // Unique slug
  description?: string | null; // Optional description
  is_active?: boolean;      // Optional, default true
}

export type CategoryBasicInfoForm = Pick<
  CategoryFormItem,
  'name' | 'slug'
>;

export interface UpdateCategorySlugForm {
  current_slug: string;    // For validation or confirmation
  new_slug: string;        // New slug to update to
}
