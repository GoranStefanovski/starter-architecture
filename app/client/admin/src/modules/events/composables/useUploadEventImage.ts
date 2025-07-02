import { useMutation } from '@tanstack/vue-query';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { EVENT_API_ENDPOINTS } from '../constants';
import type { GetEventResponse } from '../types';

interface UseUploadEventImageProps {
  eventId?: number;
  onSuccess?: () => Promise<void>;
}

export const useUploadEventImage = ({ eventId, onSuccess }: UseUploadEventImageProps) => {
  const toast = useToast();

  const { mutate: uploadEventImage, isPending: isUploadingEventImage } = useMutation({
    mutationFn: async (file: File): Promise<GetEventResponse> => {
      const formData = new FormData();
      formData.append('event_image', file);

      const response = await axios.post(EVENT_API_ENDPOINTS.uploadEventImage(eventId ?? 0), formData, {
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
