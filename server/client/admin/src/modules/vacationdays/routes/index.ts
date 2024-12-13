import type { RouteRecordRaw } from "vue-router";
import { USER_PERMISSIONS, VACATION_DAY_ROUTE_DATA } from "../constants";
import { i18n } from "@/plugins/i18n";
const { t } = i18n.global;

const VacationDays = () =>
  import(
    /* webpackChunkName: "vacationDays" */
    /* webpackPrefetch: true */
    "../pages/VacationDaysList.vue"
  );

const VacationDayPage = () =>
  import(
    /* webpackChunkName: "vacationday-page" */
    /* webpackPrefetch: true */
    "../pages/VacationDayPage.vue"
  );



const { add, main, edit } = VACATION_DAY_ROUTE_DATA;

export const VacationDayRoutes: RouteRecordRaw[] = [
  {
    path: main.path,
    name: main.name,
    component: VacationDays,
    meta: {
      auth: {
        roles: [USER_PERMISSIONS.readVacationDays],
      },
    },
  },
  {
    path: add.path,
    name: add.name,
    component: VacationDayPage,
    meta: {
      title: t(add.translationKey, null),
      auth: {
        roles: [USER_PERMISSIONS.writeVacationDays],
      },
    },
  },
  {
    path: edit.path,
    name: edit.name,
    component: VacationDayPage,
    meta: {
      title: t(edit.translationKey, null),
      auth: {
        roles: [USER_PERMISSIONS.deleteVacationDays],
      },
    },
  },
];
