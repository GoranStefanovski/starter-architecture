import type { Permission, UserRoleId } from "./permissions";
import type { PaginationObject } from "@starter-core/dash-ui/src/components";

export interface GetLeaveRequestResponse {
  id: number;
  user_id: number;
  leave_type_id: number;
  start_date: Date;
  end_date: Date;
  status: number;
  reason: string;
  request_to: number;
  approved_by: number;
}

export interface UsersTableResponse {
  data: GetLeaveRequestResponse[];
  pagination: PaginationObject;
}
