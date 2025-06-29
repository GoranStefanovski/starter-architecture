export const USER_PERMISSIONS = {
  dashboardView: 'dashboard_view',
  readUsers: 'read_users',
  writeUsers: 'write_users',
  deleteUsers: 'delete_users',
  readVenues: 'read_venues',
  writeVenues: 'write_venues',
  deleteVenues: 'delete_venues',
  readEvents: 'read_events',
  writeEvents: 'write_events',
  deleteEvents: 'delete_events',
  writePublic: 'write_public',
} as const;

export const USER_ROLES = {
  admin: 1,
  collaborator: 2,
  organization: 3,
  artist: 4,
  public: 5,
} as const;

export const USER_CHECK_BY = {
  roles: 'roles',
  permissions: 'permissions',
} as const;
