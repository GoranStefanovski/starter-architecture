export const VENUE_API_ENDPOINTS = {
  get: (venueId: number) => `/venue/get/${venueId}`,
  create: '/venue/create',
  patch: (venueId: number) => `/venue/${venueId}`,
  uploadVenueImage: (venueId: number) => `/venue/image/${venueId}`,
  deleteVenueImage: (venueId: number, imageId: number) => `/venue/${venueId}/delete-image/${imageId}`,
  delete: (venueId: number) => `/venue/delete/${venueId}`,
  table: 'venue/draw',
  getVenueTypes: '/taxonomies/venue-types',
};

export const VENUES_TABLE_QUERY_KEY = 'venues-table';
export const MY_PROFILE_CACHE_KEY = 'my-profile';
