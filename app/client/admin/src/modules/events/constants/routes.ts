import { USER_PERMISSIONS } from '@/modules/events/constants';
import type { ModulesRoutesData } from '@/types/routes';

export const EVENTS_ROUTES = {
  main: 'main',
  add: 'add',
  edit: 'edit',
} as const;

type eventsRoutes = (typeof EVENTS_ROUTES)[keyof typeof EVENTS_ROUTES];

export const EVENT_ROUTES_DATA: ModulesRoutesData<eventsRoutes> = {
  main: {
    path: 'events',
    name: 'events',
    translationKey: 'events',
    authRoles: [USER_PERMISSIONS.readEvents],
  },
  add: {
    path: 'event/add',
    name: 'add.event',
    translationKey: 'events.add',
    authRoles: [USER_PERMISSIONS.writeEvents],
  },
  edit: {
    path: 'event/:eventId',
    name: 'edit.event',
    translationKey: 'events.edit_event',
    authRoles: [USER_PERMISSIONS.writeEvents],
  },
};
