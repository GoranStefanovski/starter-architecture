import { useMutation } from '@tanstack/vue-query';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { POST_API_ENDPOINTS } from '../constants';
import type { GetPostResponse } from '../types';

interface UseUploadEventImageProps {
  postId?: number;
  onSuccess?: () => Promise<void>;
}

export const useUploadEventImage = ({ postId, onSuccess }: UseUploadEventImageProps) => {
  const toast = useToast();

  const { mutate: uploadEventImage, isPending: isUploadingEventImage } = useMutation({
    mutationFn: async (file: File): Promise<GetPostResponse> => {
      const formData = new FormData();
      formData.append('event_image', file);

      const response = await axios.post(POST_API_ENDPOINTS.uploadEventImage(postId ?? 0), formData, {
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
