import { USER_PERMISSIONS } from '@/modules/posts/constants';
import type { ModulesRoutesData } from '@/types/routes';

export const POSTS_ROUTES = {
  main: 'main',
  add: 'add',
  edit: 'edit',
} as const;

type postsRoutes = (typeof POSTS_ROUTES)[keyof typeof POSTS_ROUTES];

export const POST_ROUTES_DATA: ModulesRoutesData<postsRoutes> = {
  main: {
    path: 'posts',
    name: 'posts',
    translationKey: 'posts',
    authRoles: [USER_PERMISSIONS.readPosts],
  },
  add: {
    path: 'post/add',
    name: 'add.post',
    translationKey: 'posts.add',
    authRoles: [USER_PERMISSIONS.writePosts],
  },
  edit: {
    path: 'post/:postId',
    name: 'edit.post',
    translationKey: 'posts.edit_post',
    authRoles: [USER_PERMISSIONS.writePosts],
  },
};
