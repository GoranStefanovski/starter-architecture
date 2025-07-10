import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { VENUE_API_ENDPOINTS } from '../constants';
import type { UserFormItem, GetVenueResponse, VenueTypeResponse, CollaboratorsResponse } from '../types';
import { useUploadVenueImage } from './useUploadVenueImage';

const VENUE_CACHE_KEY = 'venue';

export const useVenuesForm = (venueId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();
  const { uploadVenueImage, isLoading: isUploadingAvatar } = useUploadVenueImage({
    venueId,
    onSuccess: async () => {
      void queryClient.invalidateQueries({ queryKey: [VENUE_CACHE_KEY, venueId] });
      toast.success('Image has been updated!');
    },
  });

  const { mutate: deleteVenueImage, isPending: isDeletingAvatar } = useMutation({
    mutationFn: async (imgId: number): Promise<GetVenueResponse> => {
      const response = await axios.delete(VENUE_API_ENDPOINTS.deleteVenueImage(venueId ?? 0, imgId));
      return response.data;
    },
    onSuccess: async () => {
      void queryClient.invalidateQueries({ queryKey: [VENUE_CACHE_KEY, venueId] });
      toast.success('Image has been deleted!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [VENUE_CACHE_KEY, venueId],
    queryFn: async (): Promise<GetVenueResponse> => {
      const data = await axios.get(VENUE_API_ENDPOINTS.get(venueId ?? 0));
      return data.data as GetVenueResponse;
    },
    enabled: !!venueId,
  });

  const { mutate: createVenue, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: UserFormItem): Promise<GetVenueResponse> => {
      const data = await axios.post(VENUE_API_ENDPOINTS.create, newUserData);
      return data.data as GetVenueResponse;
    },
    onSuccess: async () => {
      toast.success('Venue saved!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updateVenue, isPending: isUpdating } = useMutation({
    mutationFn: async (data: UserFormItem): Promise<GetVenueResponse> => {
      const response = await axios.patch(VENUE_API_ENDPOINTS.patch(venueId ?? 0), data);
      return response.data as GetVenueResponse;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [VENUE_CACHE_KEY, venueId] });
      toast.success('Venue updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: deleteVenue, isPending: isDeleting } = useMutation({
    mutationFn: async (venueId: number) => {
      await axios.post(VENUE_API_ENDPOINTS.delete(venueId));
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['venue/draw'] });
      toast.success('Venue deleted!');
    },
    onError: () => {
      toast.error('Error deleting venue!');
    },
  });

  const { data: venueTypesRaw, isLoading: isLoadingVenueTypes } = useQuery({
    queryKey: ['venue-types'],
    queryFn: async () => {
      const response = await axios.get<VenueTypeResponse[]>(VENUE_API_ENDPOINTS.getVenueTypes);
      return response.data;
    },
  });

  const { data: collaboratorsRaw, isLoading: isLoadingUsers } = useQuery({
    queryKey: ['collaborators'],
    queryFn: async () => {
      const response = await axios.get<CollaboratorsResponse[]>(VENUE_API_ENDPOINTS.getCollaborators);
      return response.data;
    },
  });

  const venueTypes = computed(() =>
    (venueTypesRaw.value || []).map((type: any) => ({
      id: type.id,
      name: type.name,
    }))
  );

  const collaborators = computed(() =>
    (collaboratorsRaw.value || []).map((collaborator: any) => ({
      id: collaborator.id,
      name: collaborator.email,
    }))
  );

  const data = computed(() => queryData.value);

  return {
    data,
    createVenue,
    updateVenue,
    uploadVenueImage,
    deleteVenueImage,
    deleteVenue,
    venueTypes,
    collaborators,
    isLoading: isFetching || isUpdating || isCreating || isUploadingAvatar || isLoadingVenueTypes || isDeleting || isLoadingUsers,
  };
};
