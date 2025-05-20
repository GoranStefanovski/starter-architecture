export const USER_PERMISSIONS = {
  readUsers: 'read_users',
  writeUsers: 'write_users',
  deleteUsers: 'delete_users',
} as const;

export const USER_ROLES = {
  admin: 1,
  collaborator: 2,
  organization: 3,
} as const;

export const USER_CHECK_BY = {
  roles: 'roles',
  permissions: 'permissions',
} as const;
