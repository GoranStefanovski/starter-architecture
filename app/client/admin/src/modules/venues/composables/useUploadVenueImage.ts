import { useMutation } from '@tanstack/vue-query';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { VENUE_API_ENDPOINTS } from '../constants';
import type { GetVenueResponse } from '../types';

interface UseUploadAvatarProps {
  venueId?: number;
  onSuccess?: () => Promise<void>;
}

export const useUploadVenueImage = ({ venueId, onSuccess }: UseUploadAvatarProps) => {
  const toast = useToast();

  const { mutate: uploadVenueImage, isPending: isUploadingAvatar } = useMutation({
    mutationFn: async (file: File): Promise<GetVenueResponse> => {
      const formData = new FormData();
      formData.append('venue_image', file);

      const response = await axios.post(VENUE_API_ENDPOINTS.uploadVenueImage(venueId ?? 0), formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      return response.data;
    },
    onSuccess,
    onError: (error) => {
      toast.error(error.message);
    },
  });

  return {
    uploadVenueImage,
    isLoading: isUploadingAvatar,
  };
};
