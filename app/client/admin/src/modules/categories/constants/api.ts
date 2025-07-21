export const CATEGORY_API_ENDPOINTS = {
  get: (categoryId: number) => `/categories/${categoryId}`,
  getAll: '/categories',
  create: '/categories',
  patch: (categoryId: number) => `/categories/${categoryId}`, // PUT/PATCH
  delete: (categoryId: number) => `/categories/${categoryId}`,
  table: '/categories/draw',
};

export const CATEGORIES_TABLE_QUERY_KEY = 'categories-table';
