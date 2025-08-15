export const POST_SLOT_API_ENDPOINTS = {
  get: (postSlotId: number) => `/taxonomies/post_slot/${postSlotId}`,
  create: '/taxonomies/post_slots/create',
  patch: (postSlotId: number) => `/taxonomies/post_slots/update/${postSlotId}`,
  table: 'taxonomies/post_slots',
};

export const POST_SLOTS_TABLE_QUERY_KEY = 'post-slots-table';
