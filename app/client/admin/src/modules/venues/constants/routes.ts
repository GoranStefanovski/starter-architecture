import { USER_PERMISSIONS } from '@/modules/venues/constants';
import type { ModulesRoutesData } from '@/types/routes';

export const VENUES_ROUTES = {
  main: 'main',
  add: 'add',
  edit: 'edit',
} as const;

type venuesRoutes = (typeof VENUES_ROUTES)[keyof typeof VENUES_ROUTES];

export const VENUE_ROUTES_DATA: ModulesRoutesData<venuesRoutes> = {
  main: {
    path: 'venues',
    name: 'venues',
    translationKey: 'venues',
    authRoles: [USER_PERMISSIONS.readVenues],
  },
  add: {
    path: 'venue/add',
    name: 'add.venue',
    translationKey: 'venues.add',
    authRoles: [USER_PERMISSIONS.writeVenues],
  },
  edit: {
    path: 'venue/:venueId',
    name: 'edit.venue',
    translationKey: 'venues.edit_venue',
    authRoles: [USER_PERMISSIONS.writeVenues],
  },
};
