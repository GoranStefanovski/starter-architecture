export const USER_API_ENDPOINTS = {
  get: (eventId: number) => `/event/get/${eventId}`,
  create: '/event/create',
  patch: (eventId: number) => `/event/update/${eventId}`,
  uploadAvatar: (eventId: number) => `/event/avatar/${eventId}`,
  table: 'event/draw',
  getMusicGenres: '/taxonomies/music-genres',
};

export const USERS_TABLE_QUERY_KEY = 'events-table';
export const MY_PROFILE_CACHE_KEY = 'my-profile';
