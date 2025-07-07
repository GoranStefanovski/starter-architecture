import { useMutation } from '@tanstack/vue-query';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { VENUE_API_ENDPOINTS } from '../constants';
import type { GetVenueResponse } from '../types';

interface UseUploadAvatarProps {
  venueId?: number;
  onSuccess?: () => Promise<void>;
}
interface UploadVenueImageInput {
  file: File;
  image_type: string;
}

export const useUploadVenueImage = ({ venueId, onSuccess }: UseUploadAvatarProps) => {
  const toast = useToast();

  const { mutate: uploadVenueImage, isPending: isUploadingAvatar } = useMutation({
    mutationFn: async ({ file, image_type }: UploadVenueImageInput): Promise<GetVenueResponse> => {
      const formData = new FormData();
      formData.append(image_type, file);

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
