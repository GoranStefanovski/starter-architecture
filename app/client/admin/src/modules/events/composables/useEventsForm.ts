import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { EVENT_API_ENDPOINTS, EVENTS_TABLE_QUERY_KEY } from '../constants';
import type { EventFormItem, GetEventResponse, GetEventDataRowResponse, MusicGenreResponse, TicketTypesResponse } from '../types';
import { useUploadEventImage } from './useUploadEventImage';

const EVENT_CACHE_KEY = 'event';

export const useEventsForm = (eventId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();
  const { uploadEventImage, isLoading: isUploadingEventImage } = useUploadEventImage({
    eventId,
    onSuccess: async () => {
      void queryClient.invalidateQueries({ queryKey: [EVENT_CACHE_KEY, eventId] });
      toast.success('Image has been updated!');
    },
  });

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [EVENT_CACHE_KEY, eventId],
    queryFn: async (): Promise<GetEventResponse> => {
      const data = await axios.get(EVENT_API_ENDPOINTS.get(eventId ?? 0));
      return data.data as GetEventResponse;
    },
    enabled: !!eventId,
  });

  const { mutate: createEvent, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: EventFormItem): Promise<GetEventResponse> => {
      const data = await axios.post(EVENT_API_ENDPOINTS.create, newUserData);
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
    mutationFn: async (data: EventFormItem): Promise<GetEventResponse> => {
      const response = await axios.patch(EVENT_API_ENDPOINTS.patch(eventId ?? 0), data);
      return response.data as GetEventResponse;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [EVENT_CACHE_KEY, eventId] });
      toast.success('User updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: deleteEvent, isPending: isDeleting } = useMutation({
    mutationFn: async (eventId: number) => {
      await axios.post(EVENT_API_ENDPOINTS.delete(eventId));
    },
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: [EVENTS_TABLE_QUERY_KEY] });
      toast.success('Event deleted!');
    },
    onError: () => {
      toast.error('Error deleting event!');
    },
  });

  const { data: musicGenresRaw, isLoading: isLoadingMusicGenres } = useQuery({
    queryKey: ['music-genres'],
    queryFn: async () => {
      const response = await axios.get<MusicGenreResponse[]>(EVENT_API_ENDPOINTS.getMusicGenres);
      return response.data;
    },
  });

  const { data: ticketTypesRaw, isLoading: isLoadingTicketTypes } = useQuery({
    queryKey: ['ticket-types'],
    queryFn: async () => {
      const response = await axios.get<TicketTypesResponse>(EVENT_API_ENDPOINTS.getTicketTypes);
      return response.data;
    },
  });

  const musicGenres = computed(() =>
    (musicGenresRaw.value || []).map((type: any) => ({
      id: type.id,
      name: type.name,
    }))
  );

  const ticketTypes = computed(() =>
    (ticketTypesRaw.value?.types || []).map((type: any) => ({
      id: type,
      name: type.replace('_', ' ').toUpperCase(),
    }))
  );

  const data = computed(() => queryData.value);

  return {
    data,
    createEvent,
    updateEvent,
    uploadEventImage,
    deleteEvent,
    musicGenres,
    ticketTypes,
    isLoading: isFetching || isUpdating || isCreating || isUploadingEventImage || isLoadingMusicGenres || isLoadingTicketTypes,
  };
};
