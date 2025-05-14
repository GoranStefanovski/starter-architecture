import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { USER_API_ENDPOINTS, USERS_TABLE_QUERY_KEY } from '../constants';
import type { UserFormItem, GetUserResponse } from '../types';
import { useUploadAvatar } from './useUploadAvatar';

const USER_CACHE_KEY = 'user';

export const useUsersForm = (userId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();
  const { uploadAvatar, isLoading: isUploadingAvatar } = useUploadAvatar({
    userId,
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, userId] });
      toast.success('Image has been updated!');
    },
  });

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [USER_CACHE_KEY, userId],
    queryFn: async (): Promise<GetUserResponse> => {
      const data = await axios.get(USER_API_ENDPOINTS.get(userId ?? 0));
      return data.data;
    },
    enabled: !!userId,
  });

  const { mutate: createUser, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: UserFormItem): Promise<GetUserResponse> => {
      const data = await axios.post(USER_API_ENDPOINTS.create, newUserData);
      return data.data;
    },
    onSuccess: async () => {
      toast.success('User saved!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updateUser, isPending: isUpdating } = useMutation({
    mutationFn: async (data: UserFormItem): Promise<GetUserResponse> => {
      const response = await axios.patch(USER_API_ENDPOINTS.patch(userId ?? 0), data);
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, userId] });
      toast.success('User updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });
  const { mutate: deleteUser, isPending: isDeleting } = useMutation({
    mutationFn: async (data: UserFormItem): Promise<GetUserResponse> => {
      const response = await axios.delete(USER_API_ENDPOINTS.delete(userId ?? 0));
      return response.data;
    },
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: [USERS_TABLE_QUERY_KEY] });
      toast.success('User deleted!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const data = computed(() => queryData.value);

  return {
    data,
    createUser,
    updateUser,
    uploadAvatar,
    deleteUser,
    isLoading: isFetching || isUpdating || isCreating || isUploadingAvatar || isDeleting,
  };
};
