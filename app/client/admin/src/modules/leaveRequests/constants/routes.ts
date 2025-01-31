import type { ModulesRoutesData } from "@/types/routes";

export const LEAVE_REQUESTS_ROUTES = {
  main: "main",
  add: "add",
  edit: "edit",
} as const;

type LeaveRequestsRoutes = (typeof LEAVE_REQUESTS_ROUTES)[keyof typeof LEAVE_REQUESTS_ROUTES];

export const LEAVE_REQUEST_ROUTES_DATA: ModulesRoutesData<LeaveRequestsRoutes> = {
  main: {
    path: "leave_requests",
    name: "leave_requests",
    translationKey: "leave_requests",
  },
  add: {
    path: "leave_request/add",
    name: "add.leave_request",
    translationKey: "leave_requests.add",
  },
  edit: {
    path: "leave_request/:leaveRequestId",
    name: "edit.leave_request",
    translationKey: "leave_requests.edit_leave_requests",
  },

};
