import { USER_PERMISSIONS } from '@/modules/users/constants';
import type { ModulesRoutesData } from '@/types/routes';

export const STORES_ROUTES = {
  main: 'main',
  add: 'add',
  edit: 'edit',
} as const;

type storesRoutes = (typeof STORES_ROUTES)[keyof typeof STORES_ROUTES];

export const CATEGORY_ROUTES_DATA: ModulesRoutesData<storesRoutes> = {
  main: {
    path: 'categories',
    name: 'categories',
    translationKey: 'categories',
    authRoles: [USER_PERMISSIONS.readStore],
  },
  add: {
    path: 'category/add',
    name: 'add.category',
    translationKey: 'categories.add',
    authRoles: [USER_PERMISSIONS.writeStore],
  },
  edit: {
    path: 'category/:categoryId',
    name: 'edit.category',
    translationKey: 'categories.edit_category',
    authRoles: [USER_PERMISSIONS.writeStore],
  },
};
