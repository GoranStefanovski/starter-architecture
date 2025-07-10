import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { USER_API_ENDPOINTS, USERS_TABLE_QUERY_KEY } from '../constants';
import type { StoreFormItem, GetStoreResponse } from '../types';
import { useUploadAvatar } from './useUploadAvatar';

const STORE_CACHE_KEY = 'user';

export const useStoresForm = (storeId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();

  const { uploadAvatar, isLoading: isUploadingAvatar } = useUploadAvatar({
    storeId,
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [STORE_CACHE_KEY, storeId] });
      toast.success('Image has been updated!');
    },
  });

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [STORE_CACHE_KEY, storeId],
    queryFn: async (): Promise<GetStoreResponse> => {
      const data = await axios.get(USER_API_ENDPOINTS.get(storeId ?? 0));
      return data.data;
    },
    enabled: !!storeId,
  });

  const { mutate: createStore, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: StoreFormItem): Promise<GetStoreResponse> => {
      const data = await axios.post(USER_API_ENDPOINTS.create, newUserData);
      return data.data;
    },
    onSuccess: async () => {
      toast.success('Store saved!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updateStore, isPending: isUpdating } = useMutation({
    mutationFn: async (data: StoreFormItem): Promise<GetStoreResponse> => {
      const response = await axios.patch(USER_API_ENDPOINTS.patch(storeId ?? 0), data);
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [STORE_CACHE_KEY, storeId] });
      toast.success('Store updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });
  const { mutate: deleteStore, isPending: isDeleting } = useMutation({
    mutationFn: async (data: StoreFormItem): Promise<GetStoreResponse> => {
      const response = await axios.delete(USER_API_ENDPOINTS.delete(storeId ?? 0));
      return response.data;
    },
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: [USERS_TABLE_QUERY_KEY] });
      toast.success('Store deleted!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const data = computed(() => queryData.value);

  return {
    data,
    createStore,
    updateStore,
    uploadAvatar,
    deleteStore,
    isLoading: isFetching || isUpdating || isCreating || isUploadingAvatar || isDeleting,
  };
};
