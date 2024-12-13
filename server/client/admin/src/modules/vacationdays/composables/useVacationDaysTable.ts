import { useQuery, UseQueryReturnType } from "@tanstack/vue-query";
import axios, { type AxiosError } from "axios";
import type { ComputedRef } from "vue";
import { VACATION_DAY_API_ENDPOINTS, VACATION_DAYS_TABLE_QUERY_KEY } from "../constants";
import type { VacationDaysTableResponse } from "../types";
import type { TableQuery } from "@starter-core/dash-ui/src";

export const useVacationDaysTable = (
  query: ComputedRef<TableQuery>,
): UseQueryReturnType<VacationDaysTableResponse, AxiosError> => {
  return useQuery({
    queryKey: [VACATION_DAYS_TABLE_QUERY_KEY, query],
    queryFn: async () => {
      const response = await axios.get(VACATION_DAY_API_ENDPOINTS.table, {
        params: query.value,
      });
      return response.data;
    },
  });
};
