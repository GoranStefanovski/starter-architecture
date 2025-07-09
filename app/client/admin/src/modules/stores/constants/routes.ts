import { USER_PERMISSIONS } from '@/modules/users/constants';
import type { ModulesRoutesData } from '@/types/routes';

export const STORES_ROUTES = {
  main: 'main',
  add: 'add',
  edit: 'edit',
} as const;

type storesRoutes = (typeof STORES_ROUTES)[keyof typeof STORES_ROUTES];

export const USER_ROUTES_DATA: ModulesRoutesData<storesRoutes> = {
  main: {
    path: 'stores',
    name: 'stores',
    translationKey: 'stores',
    authRoles: [USER_PERMISSIONS.readStore],
  },
  add: {
    path: 'store/add',
    name: 'add.store',
    translationKey: 'stores.add',
    authRoles: [USER_PERMISSIONS.deleteStore],
  },
  edit: {
    path: 'store/:storeId',
    name: 'edit.store',
    translationKey: 'stores.edit_store',
    authRoles: [USER_PERMISSIONS.writeStore],
  },
};
