export const USER_PERMISSIONS = {
  readVenues: 'read_venues',
  writeVenues: 'write_venues',
  deleteVenues: 'delete_venues',
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
