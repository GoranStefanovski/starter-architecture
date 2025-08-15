import type { UseQueryReturnType } from '@tanstack/vue-query';
import { useQuery } from '@tanstack/vue-query';
import axios, { type AxiosError } from 'axios';
import type { ComputedRef } from 'vue';
import { POST_API_ENDPOINTS, POSTS_TABLE_QUERY_KEY } from '../constants';
import type { PostsTableResponse } from '../types';
import type { TableQuery } from '@starter-core/dash-ui/src';

export const usePostsTable = (query: ComputedRef<TableQuery>): UseQueryReturnType<PostsTableResponse, AxiosError> => {
  return useQuery({
    queryKey: [POSTS_TABLE_QUERY_KEY, query],
    queryFn: async () => {
      const response = await axios.get(POST_API_ENDPOINTS.table, {
        params: query.value,
      });
      return response.data;
    },
  });
};
