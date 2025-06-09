import type { RouteRecordRaw } from 'vue-router';
import { EVENT_ROUTES_DATA } from '../constants';
import { i18n } from '@/plugins/i18n';
const { t } = i18n.global;

const Events = () =>
  import(
    /* webpackChunkName: "events" */
    /* webpackPrefetch: true */
    '../pages/EventsList.vue'
  );

const EventPage = () =>
  import(
    /* webpackChunkName: "event-page" */
    /* webpackPrefetch: true */
    '../pages/EventPage.vue'
  );

const { add, main, edit } = EVENT_ROUTES_DATA;

export const eventsRoutes: RouteRecordRaw[] = [
  {
    path: main.path,
    name: main.name,
    component: Events,
    meta: {
      auth: {
        roles: main.authRoles,
      },
    },
  },
  {
    path: add.path,
    name: add.name,
    component: EventPage,
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
    component: EventPage,
    meta: {
      title: t(edit.translationKey, null),
      auth: {
        roles: edit.authRoles,
      },
    },
  },
];
