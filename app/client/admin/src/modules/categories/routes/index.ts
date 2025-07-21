import type { RouteRecordRaw } from 'vue-router';
import { CATEGORY_ROUTES_DATA } from '../constants';
import { i18n } from '@/plugins/i18n';
const { t } = i18n.global;

const Categories = () =>
  import(
    /* webpackChunkName: "users" */
    /* webpackPrefetch: true */
    '../pages/CategoriesList.vue'
  );

const CategoryPage = () =>
  import(
    /* webpackChunkName: "user-page" */
    /* webpackPrefetch: true */
    '../pages/CategoryPage.vue'
  );

const { add, main, edit } = CATEGORY_ROUTES_DATA;
export const categoriesRoutes: RouteRecordRaw[] = [
  {
    path: main.path,
    name: main.name,
    component: Categories,
    meta: {
      auth: {
        roles: main.authRoles,
      },
    },
  },
  {
    path: add.path,
    name: add.name,
    component: CategoryPage,
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
    component: CategoryPage,
    meta: {
      title: t(edit.translationKey, null),
      auth: {
        roles: edit.authRoles,
      },
    },
  },
];
