import type { PaginationObject } from "@starter-core/dash-ui/src/components";

export interface GetVacationDayResponse {
  id: number;
  user_id: number;
  day_type_id: number;
  date_from: Date;
  date_to: Date;
  year: number;
}

export interface VacationDaysTableResponse {
  data: GetVacationDayResponse[];
  pagination: PaginationObject;
}
