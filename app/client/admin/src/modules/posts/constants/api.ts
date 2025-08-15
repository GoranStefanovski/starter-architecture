export const POST_API_ENDPOINTS = {
  get: (postId: number) => `/post/get/${postId}`,
  create: '/post/create',
  patch: (postId: number) => `/post/update/${postId}`,
  uploadEventImage: (postId: number) => `/post/image/${postId}`,
  delete: (postId: number) => `/post/delete/${postId}`,
  table: 'post/draw',
};

export const POSTS_TABLE_QUERY_KEY = 'posts-table';
