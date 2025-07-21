import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { CATEGORY_API_ENDPOINTS, CATEGORIES_TABLE_QUERY_KEY } from '../constants';
import type { CategoryFormItem, GetCategoryResponse } from '../types';

const CATEGORY_CACHE_KEY = 'category';

export const useCategoriesForm = (categoryId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [CATEGORY_CACHE_KEY, categoryId],
    queryFn: async (): Promise<GetCategoryResponse> => {
      const data = await axios.get(CATEGORY_API_ENDPOINTS.get(categoryId ?? 0));
      return data.data;
    },
    enabled: !!categoryId,
  });

  const { mutate: createCategory, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: CategoryFormItem): Promise<GetCategoryResponse> => {
      const data = await axios.post(CATEGORY_API_ENDPOINTS.create, newUserData);
      return data.data;
    },
    onSuccess: async () => {
      toast.success('Category saved!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updateCategory, isPending: isUpdating } = useMutation({
    mutationFn: async (data: CategoryFormItem): Promise<GetCategoryResponse> => {
      const response = await axios.patch(CATEGORY_API_ENDPOINTS.patch(categoryId ?? 0), data);
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [CATEGORY_CACHE_KEY, categoryId] });
      toast.success('Category updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });
  const { mutate: deleteCategory, isPending: isDeleting } = useMutation({
    mutationFn: async (data: CategoryFormItem): Promise<GetCategoryResponse> => {
      const response = await axios.delete(CATEGORY_API_ENDPOINTS.delete(categoryId ?? 0));
      return response.data;
    },
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: [CATEGORIES_TABLE_QUERY_KEY] });
      toast.success('Category deleted!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const data = computed(() => queryData.value);

  return {
    data,
    createCategory,
    updateCategory,
    deleteCategory,
    isLoading: isFetching || isUpdating || isCreating || isDeleting,
  };
};
