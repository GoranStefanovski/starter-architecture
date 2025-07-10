export interface StoreFormItem {
  id?: number;              // Optional for create, required for update
  name: string;             // Store name
  slug: string;             // Unique slug
  domain: string;           // Store domain (e.g., mystore.com)
  address?: string | null;  // Optional
  phone?: string | null;    // Optional
  email?: string | null;    // Optional
  website?: string | null;  // Optional
  description?: string | null; // Optional
  is_active?: boolean;    // Optional, default false
}

export type StoreBasicInfoForm = Pick<
  StoreFormItem,
  'name' | 'slug' | 'domain'
>;

export interface UpdateStoreDomainForm {
  current_domain: string;    // For validation or confirmation
  new_domain: string;        // New domain to update to
}
