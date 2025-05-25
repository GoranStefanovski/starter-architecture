import { useMutation } from '@tanstack/vue-query';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { USER_API_ENDPOINTS } from '../constants';
import type { GetVenueResponse } from '../types';

interface UseUploadAvatarProps {
  venueId?: number;
  onSuccess?: () => Promise<void>;
}

export const useUploadAvatar = ({ venueId, onSuccess }: UseUploadAvatarProps) => {
  const toast = useToast();

  const { mutate: uploadAvatar, isPending: isUploadingAvatar } = useMutation({
    mutationFn: async (file: File): Promise<GetVenueResponse> => {
      const formData = new FormData();
      formData.append('avatar', file);

      const response = await axios.post(USER_API_ENDPOINTS.uploadAvatar(venueId ?? 0), formData, {
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
    uploadAvatar,
    isLoading: isUploadingAvatar,
  };
};
