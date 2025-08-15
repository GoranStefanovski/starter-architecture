import type { UseQueryReturnType } from '@tanstack/vue-query';
import { useQuery } from '@tanstack/vue-query';
import axios, { type AxiosError } from 'axios';
import type { ComputedRef } from 'vue';
import { POST_SLOT_API_ENDPOINTS, POST_SLOTS_TABLE_QUERY_KEY } from '../constants';
import type { EventsTableResponse } from '../types';
import type { TableQuery } from '@starter-core/dash-ui/src';

export const usePostsTable = (query: ComputedRef<TableQuery>): UseQueryReturnType<EventsTableResponse, AxiosError> => {
  return useQuery({
    queryKey: [POST_SLOTS_TABLE_QUERY_KEY, query],
    queryFn: async () => {
      const response = await axios.get(POST_SLOT_API_ENDPOINTS.table, {
        params: query.value,
      });
      return response.data;
    },
  });
};
