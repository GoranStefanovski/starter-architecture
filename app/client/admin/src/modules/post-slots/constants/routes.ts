import { USER_PERMISSIONS } from '@/modules/post-slots/constants';
import type { ModulesRoutesData } from '@/types/routes';

export const POST_SLOTS_ROUTES = {
  main: 'main',
  add: 'add',
  edit: 'edit',
} as const;

type postSlotsRoutes = (typeof POST_SLOTS_ROUTES)[keyof typeof POST_SLOTS_ROUTES];

export const EVENT_ROUTES_DATA: ModulesRoutesData<postSlotsRoutes> = {
  main: {
    path: 'post-slots',
    name: 'post-slots',
    translationKey: 'post-slots',
    authRoles: [USER_PERMISSIONS.readPosts],
  },
  add: {
    path: 'post-slot/add',
    name: 'add.post-slot',
    translationKey: 'post-slots.add',
    authRoles: [USER_PERMISSIONS.writePosts],
  },
  edit: {
    path: 'post-slot/:postSlotId',
    name: 'edit.post-slot',
    translationKey: 'post-slots.edit_post_slot',
    authRoles: [USER_PERMISSIONS.writePosts],
  },
};
