export const USER_PERMISSIONS = {
  readPosts: 'read_posts',
  writePosts: 'write_posts',
  deletePosts: 'delete_posts',
} as const;

export const USER_ROLES = {
  admin: 1,
  collaborator: 2,
  organization: 3,
  //TODO: have to add Artist role
} as const;

export const USER_CHECK_BY = {
  roles: 'roles',
  permissions: 'permissions',
} as const;
