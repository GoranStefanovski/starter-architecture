import { useMutation } from '@tanstack/vue-query';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { POST_SLOT_API_ENDPOINTS } from '../constants';
import type { GetPostSlotResponse } from '../types';

interface UseUploadEventImageProps {
  postSlotId?: number;
  onSuccess?: () => Promise<void>;
}

export const useUploadEventImage = ({ postSlotId, onSuccess }: UseUploadEventImageProps) => {
  const toast = useToast();

  const { mutate: uploadEventImage, isPending: isUploadingEventImage } = useMutation({
    mutationFn: async (file: File): Promise<GetPostSlotResponse> => {
      const formData = new FormData();
      formData.append('event_image', file);

      const response = await axios.post(POST_SLOT_API_ENDPOINTS.uploadEventImage(postSlotId ?? 0), formData, {
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
    uploadEventImage,
    isLoading: isUploadingEventImage,
  };
};
