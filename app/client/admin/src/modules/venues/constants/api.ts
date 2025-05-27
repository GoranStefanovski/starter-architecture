export const USER_API_ENDPOINTS = {
  get: (venueId: number) => `/venue/${venueId}`,
  create: '/venue/create',
  patch: (venueId: number) => `/venue/${venueId}`,
  uploadAvatar: (venueId: number) => `/venue/avatar/${venueId}`,
  table: 'venue/draw',
  getVenueTypes: '/taxonomies/venue-types',
};

export const USERS_TABLE_QUERY_KEY = 'venues-table';
export const MY_PROFILE_CACHE_KEY = 'my-profile';
