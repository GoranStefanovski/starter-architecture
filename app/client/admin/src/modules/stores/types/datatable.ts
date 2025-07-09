export interface StoreRecord {
  id: number;
  name: string;
  slug: string;
  domain: string;
  address?: string | null;
  phone?: string | null;
  email?: string | null;
  website?: string | null;
  description?: string | null;
}
