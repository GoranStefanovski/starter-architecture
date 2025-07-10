export const USER_API_ENDPOINTS = {
  get: (storeId: number) => `/store/${storeId}`,
  getAll: 'store/all',
  create: '/store/create',
  patch: (storeId: number) => `/store/${storeId}`,
  delete: (storeId: number) => `/store/${storeId}`,
  uploadAvatar: (storeId: number) => `/store/avatar/${storeId}`,
  table: 'store/draw',
};

export const USERS_TABLE_QUERY_KEY = 'stores-table';
