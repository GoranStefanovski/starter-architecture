export const EVENT_API_ENDPOINTS = {
  get: (eventId: number) => `/event/get/${eventId}`,
  create: '/event/create',
  patch: (eventId: number) => `/event/update/${eventId}`,
  uploadEventImage: (eventId: number) => `/event/image/${eventId}`,
  table: 'event/draw',
  getMusicGenres: '/taxonomies/music-genres',
  getTicketTypes: '/taxonomies/ticket-types',
  getVenueFromCity: (city: string) => `/venue/by-city/${city}`,
};

export const EVENTS_TABLE_QUERY_KEY = 'events-table';
export const MY_PROFILE_CACHE_KEY = 'my-profile';
