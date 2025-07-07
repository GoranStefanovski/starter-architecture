import { useMutation } from '@tanstack/vue-query';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { VENUE_API_ENDPOINTS } from '../constants';
import type { GetVenueResponse } from '../types';

interface UseDeleteVenueImageProps {
  venueId: number;
  onSuccess?: () => Promise<void>;
}

export const useDeleteVenueImage = ({ venueId, onSuccess }: UseDeleteVenueImageProps) => {
  const toast = useToast();

  const { mutate: deleteVenueImage, isPending: isDeletingImage } = useMutation({
    mutationFn: async (imgId: number): Promise<GetVenueResponse> => {
      const response = await axios.delete(VENUE_API_ENDPOINTS.deleteVenueImage(venueId, imgId));
      return response.data;
    },
    onSuccess,
    onError: (error) => {
      toast.error(error.message);
    },
  });

  return {
    deleteVenueImage,
    isLoading: isDeletingImage,
  };
};
