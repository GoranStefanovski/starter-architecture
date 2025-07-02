import type { UseQueryReturnType } from '@tanstack/vue-query';
import { useQuery } from '@tanstack/vue-query';
import axios, { type AxiosError } from 'axios';
import type { ComputedRef } from 'vue';
import { EVENT_API_ENDPOINTS, EVENTS_TABLE_QUERY_KEY } from '../constants';
import type { EventsTableResponse } from '../types';
import type { TableQuery } from '@starter-core/dash-ui/src';

export const useEventsTable = (query: ComputedRef<TableQuery>): UseQueryReturnType<EventsTableResponse, AxiosError> => {
  return useQuery({
    queryKey: [EVENTS_TABLE_QUERY_KEY, query],
    queryFn: async () => {
      const response = await axios.get(EVENT_API_ENDPOINTS.table, {
        params: query.value,
      });
      return response.data;
    },
  });
};
