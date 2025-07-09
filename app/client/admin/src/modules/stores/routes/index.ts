import type { RouteRecordRaw } from 'vue-router';
import { USER_ROUTES_DATA } from '../constants';
import { i18n } from '@/plugins/i18n';
const { t } = i18n.global;

const Stores = () =>
  import(
    /* webpackChunkName: "users" */
    /* webpackPrefetch: true */
    '../pages/StoresList.vue'
  );

const StorePage = () =>
  import(
    /* webpackChunkName: "user-page" */
    /* webpackPrefetch: true */
    '../pages/StorePage.vue'
  );

const { add, main, edit } = USER_ROUTES_DATA;
export const storesRoutes: RouteRecordRaw[] = [
  {
    path: main.path,
    name: main.name,
    component: Stores,
    meta: {
      auth: {
        roles: main.authRoles,
      },
    },
  },
  {
    path: add.path,
    name: add.name,
    component: StorePage,
    meta: {
      title: t(add.translationKey, null),
      auth: {
        roles: add.authRoles,
      },
    },
  },
  {
    path: edit.path,
    name: edit.name,
    component: StorePage,
    meta: {
      title: t(edit.translationKey, null),
      auth: {
        roles: edit.authRoles,
      },
    },
  },
];
