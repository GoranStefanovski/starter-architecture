import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { USER_API_ENDPOINTS } from '../constants';
import type { UserFormItem, GetEventResponse, MusicGenreResponse } from '../types';
import { useUploadAvatar } from './useUploadAvatar';

const USER_CACHE_KEY = 'user';

export const useEventsForm = (eventId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();
  const { uploadAvatar, isLoading: isUploadingAvatar } = useUploadAvatar({
    eventId,
    onSuccess: async () => {
      void queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, eventId] });
      toast.success('Image has been updated!');
    },
  });

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [USER_CACHE_KEY, eventId],
    queryFn: async (): Promise<GetEventResponse> => {
      const data = await axios.get(USER_API_ENDPOINTS.get(eventId ?? 0));
      return data.data as GetEventResponse;
    },
    enabled: !!eventId,
  });

  const { mutate: createEvent, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: UserFormItem): Promise<GetEventResponse> => {
      const data = await axios.post(USER_API_ENDPOINTS.create, newUserData);
      return data.data as GetEventResponse;
    },
    onSuccess: async () => {
      toast.success('User saved!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updateEvent, isPending: isUpdating } = useMutation({
    mutationFn: async (data: UserFormItem): Promise<GetEventResponse> => {
      const response = await axios.patch(USER_API_ENDPOINTS.patch(eventId ?? 0), data);
      return response.data as GetEventResponse;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, eventId] });
      toast.success('User updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { data: musicGenresRaw, isLoading: isLoadingMusicGenres } = useQuery({
    queryKey: ['music-genres'],
    queryFn: async () => {
      const response = await axios.get<MusicGenreResponse[]>(USER_API_ENDPOINTS.getMusicGenres);
      return response.data;
    },
  });

  const musicGenres = computed(() =>
    (musicGenresRaw.value || []).map((type: any) => ({
      id: type.id,
      name: type.name,
    }))
  );

  const data = computed(() => queryData.value);

  return {
    data,
    createEvent,
    updateEvent,
    uploadAvatar,
    musicGenres,
    isLoading: isFetching || isUpdating || isCreating || isUploadingAvatar || isLoadingMusicGenres,
  };
};
