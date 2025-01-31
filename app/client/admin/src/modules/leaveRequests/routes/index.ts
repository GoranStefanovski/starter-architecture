import type { RouteRecordRaw } from "vue-router";
import { USER_PERMISSIONS, LEAVE_REQUEST_ROUTES_DATA } from "../constants";
import { i18n } from "@/plugins/i18n";
const { t } = i18n.global;

const LeaveRequests = () =>
  import(
    /* webpackChunkName: "users" */
    /* webpackPrefetch: true */
    "../pages/LeaveRequestsList.vue"
  );

const LeaveRequestPage = () =>
  import(
    /* webpackChunkName: "user-page" */
    /* webpackPrefetch: true */
    "../pages/LeaveRequestPage.vue"
  );

const { add, main, edit } = LEAVE_REQUEST_ROUTES_DATA;

export const LeaveRequestsRoutes: RouteRecordRaw[] = [
  {
    path: main.path,
    name: main.name,
    component: LeaveRequests,
    meta: {
      auth: {
        roles: [USER_PERMISSIONS.readRequests],
      },
    },
  },
  {
    path: add.path,
    name: add.name,
    component: LeaveRequestPage,
    meta: {
      title: t(add.translationKey, null),
      auth: {
        roles: [USER_PERMISSIONS.writeRequests],
      },
    },
  },
  {
    path: edit.path,
    name: edit.name,
    component: LeaveRequestPage,
    meta: {
      title: t(edit.translationKey, null),
      auth: {
        roles: [USER_PERMISSIONS.writeRequests],
      },
    },
  },
];
