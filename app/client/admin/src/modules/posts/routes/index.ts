import type { RouteRecordRaw } from 'vue-router';
import { POST_ROUTES_DATA } from '../constants';
import { i18n } from '@/plugins/i18n';
const { t } = i18n.global;

const Posts = () =>
  import(
    /* webpackChunkName: "posts" */
    /* webpackPrefetch: true */
    '../pages/PostsList.vue'
  );

const PostPage = () =>
  import(
    /* webpackChunkName: "post-page" */
    /* webpackPrefetch: true */
    '../pages/PostPage.vue'
  );

const { add, main, edit } = POST_ROUTES_DATA;

export const postsRoutes: RouteRecordRaw[] = [
  {
    path: main.path,
    name: main.name,
    component: Posts,
    meta: {
      auth: {
        roles: main.authRoles,
      },
    },
  },
  {
    path: add.path,
    name: add.name,
    component: PostPage,
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
    component: PostPage,
    meta: {
      title: t(edit.translationKey, null),
      auth: {
        roles: edit.authRoles,
      },
    },
  },
];
