import { useQuery, UseQueryReturnType } from "@tanstack/vue-query";
import axios, { type AxiosError } from "axios";
import type { ComputedRef } from "vue";
import { USER_API_ENDPOINTS, USERS_TABLE_QUERY_KEY } from "../constants";
import type { UsersTableResponse } from "../types";
import type { TableQuery } from "@starter-core/dash-ui/src";

export const useUsersTable = (
  query: ComputedRef<TableQuery>,
) => {
  const queryResult = useQuery<UsersTableResponse, AxiosError>({
    queryKey: [USERS_TABLE_QUERY_KEY, query.value], 
    queryFn: async () => {
      const response = await axios.get(USER_API_ENDPOINTS.table, {
        params: query.value,
      });
      return response.data;
    },
  });

  return queryResult;
};
