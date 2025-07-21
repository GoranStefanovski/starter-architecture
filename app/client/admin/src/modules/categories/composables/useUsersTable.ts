import type { UseQueryReturnType } from '@tanstack/vue-query';
import { useQuery } from '@tanstack/vue-query';
import axios, { type AxiosError } from 'axios';
import type { ComputedRef } from 'vue';
import { CATEGORY_API_ENDPOINTS, CATEGORIES_TABLE_QUERY_KEY } from '../constants';
import type { CategoriesTableResponse } from '../types';
import type { TableQuery } from '@starter-core/dash-ui/src';

export const useUsersTable = (query: ComputedRef<TableQuery>): UseQueryReturnType<CategoriesTableResponse, AxiosError> => {
  return useQuery({
    queryKey: [CATEGORIES_TABLE_QUERY_KEY, query],
    queryFn: async () => {
      const response = await axios.get(CATEGORY_API_ENDPOINTS.table, {
        params: query.value,
      });
      return response.data;
    },
  });
};
