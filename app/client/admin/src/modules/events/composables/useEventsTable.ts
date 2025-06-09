import type { UseQueryReturnType } from '@tanstack/vue-query';
import { useQuery } from '@tanstack/vue-query';
import axios, { type AxiosError } from 'axios';
import type { ComputedRef } from 'vue';
import { USER_API_ENDPOINTS, USERS_TABLE_QUERY_KEY } from '../constants';
import type { EventsTableResponse } from '../types';
import type { TableQuery } from '@starter-core/dash-ui/src';

export const useEventsTable = (query: ComputedRef<TableQuery>): UseQueryReturnType<EventsTableResponse, AxiosError> => {
  return useQuery({
    queryKey: [USERS_TABLE_QUERY_KEY, query],
    queryFn: async () => {
      const response = await axios.get(USER_API_ENDPOINTS.table, {
        params: query.value,
      });
      return response.data;
    },
  });
};
