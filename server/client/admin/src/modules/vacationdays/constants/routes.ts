import type { ModulesRoutesData } from "@/types/routes";

export const VACATION_DAYS_ROUTES = {
  main: "main",
  add: "add",
  edit: "edit",
} as const;

type VacationDayRoutes = (typeof VACATION_DAYS_ROUTES)[keyof typeof VACATION_DAYS_ROUTES];

export const VACATION_DAY_ROUTE_DATA: ModulesRoutesData<VacationDayRoutes> = {
  main: {
    path: "vacationDays",
    name: "vacationDays",
    translationKey: "vacationDays",
  },
  add: {
    path: "vacationDay/add",
    name: "add.vacationDay",
    translationKey: "vacationDays.add",
  },
  edit: {
    path: "vacationDay/:vacationDayId",
    name: "edit.vacationDay",
    translationKey: "vacationDays.edit_vacationDay",
  },
};
