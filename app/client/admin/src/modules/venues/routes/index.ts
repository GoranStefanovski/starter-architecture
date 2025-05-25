import type { RouteRecordRaw } from 'vue-router';
import { VENUE_ROUTES_DATA } from '../constants';
import { i18n } from '@/plugins/i18n';
const { t } = i18n.global;

const Venues = () =>
  import(
    /* webpackChunkName: "venues" */
    /* webpackPrefetch: true */
    '../pages/VenuesList.vue'
  );

const VenuePage = () =>
  import(
    /* webpackChunkName: "venue-page" */
    /* webpackPrefetch: true */
    '../pages/VenuePage.vue'
  );

const { add, main, edit } = VENUE_ROUTES_DATA;

export const venuesRoutes: RouteRecordRaw[] = [
  {
    path: main.path,
    name: main.name,
    component: Venues,
    meta: {
      auth: {
        roles: main.authRoles,
      },
    },
  },
  {
    path: add.path,
    name: add.name,
    component: VenuePage,
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
    component: VenuePage,
    meta: {
      title: t(edit.translationKey, null),
      auth: {
        roles: edit.authRoles,
      },
    },
  },
];
