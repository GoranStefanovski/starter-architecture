import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { USER_API_ENDPOINTS } from '../constants';
import type { UserFormItem, GetVenueResponse, VenueTypeResponse } from '../types';
import { useUploadAvatar } from './useUploadAvatar';

const USER_CACHE_KEY = 'user';

export const useVenuesForm = (venueId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();
  const { uploadAvatar, isLoading: isUploadingAvatar } = useUploadAvatar({
    venueId,
    onSuccess: async () => {
      void queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, venueId] });
      toast.success('Image has been updated!');
    },
  });

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [USER_CACHE_KEY, venueId],
    queryFn: async (): Promise<GetVenueResponse> => {
      const data = await axios.get(USER_API_ENDPOINTS.get(venueId ?? 0));
      return data.data as GetVenueResponse;
    },
    enabled: !!venueId,
  });

  const { mutate: createVenue, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: UserFormItem): Promise<GetVenueResponse> => {
      const data = await axios.post(USER_API_ENDPOINTS.create, newUserData);
      return data.data as GetVenueResponse;
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
      return response.data as GetVenueResponse;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, venueId] });
      toast.success('User updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { data: venueTypesRaw, isLoading: isLoadingVenueTypes } = useQuery({
    queryKey: ['venue-types'],
    queryFn: async () => {
      const response = await axios.get<VenueTypeResponse[]>(USER_API_ENDPOINTS.getVenueTypes);
      console.log(response.data);
      return response.data;
    },
  });

  const venueTypes = computed(() =>
    (venueTypesRaw.value || []).map((type: any) => ({
      id: type.id,
      name: type.name,
    }))
  );

  const data = computed(() => queryData.value);

  return {
    data,
    createVenue,
    updateVenue,
    uploadAvatar,
    venueTypes,
    isLoading: isFetching || isUpdating || isCreating || isUploadingAvatar || isLoadingVenueTypes,
  };
};
