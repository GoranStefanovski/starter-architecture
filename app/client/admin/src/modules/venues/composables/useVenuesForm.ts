import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { USER_API_ENDPOINTS } from '../constants';
import type { UserFormItem, GetVenueResponse } from '../types';
import { useUploadAvatar } from './useUploadAvatar';

const USER_CACHE_KEY = 'user';

export const useVenuesForm = (venueId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();
  const { uploadAvatar, isLoading: isUploadingAvatar } = useUploadAvatar({
    venueId,
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, venueId] });
      toast.success('Image has been updated!');
    },
  });

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [USER_CACHE_KEY, venueId],
    queryFn: async (): Promise<GetVenueResponse> => {
      const data = await axios.get(USER_API_ENDPOINTS.get(venueId ?? 0));
      return data.data;
    },
    enabled: !!venueId,
  });

  const { mutate: createVenue, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: UserFormItem): Promise<GetVenueResponse> => {
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

  const { mutate: updateVenue, isPending: isUpdating } = useMutation({
    mutationFn: async (data: UserFormItem): Promise<GetVenueResponse> => {
      const response = await axios.patch(USER_API_ENDPOINTS.patch(venueId ?? 0), data);
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, venueId] });
      toast.success('User updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const data = computed(() => queryData.value);

  return {
    data,
    createVenue,
    updateVenue,
    uploadAvatar,
    isLoading: isFetching || isUpdating || isCreating || isUploadingAvatar,
  };
};
