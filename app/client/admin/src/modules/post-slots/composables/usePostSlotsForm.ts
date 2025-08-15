import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { POST_SLOT_API_ENDPOINTS } from '../constants';
import type { PostSlotFormItem, GetPostSlotResponse } from '../types';

const POST_SLOT_CACHE_KEY = 'post-slot';

export const usePostSlotsForm = (postSlotId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [POST_SLOT_CACHE_KEY, postSlotId],
    queryFn: async (): Promise<GetPostSlotResponse> => {
      const data = await axios.get(POST_SLOT_API_ENDPOINTS.get(postSlotId ?? 0));
      return data.data as GetPostSlotResponse;
    },
    enabled: !!postSlotId,
  });

  const { mutate: createPost, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: PostSlotFormItem): Promise<GetPostSlotResponse> => {
      const data = await axios.post(POST_SLOT_API_ENDPOINTS.create, newUserData);
      return data.data as GetPostSlotResponse;
    },
    onSuccess: async () => {
      toast.success('Post Slot saved!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updatePost, isPending: isUpdating } = useMutation({
    mutationFn: async (data: PostSlotFormItem): Promise<GetPostSlotResponse> => {
      const response = await axios.patch(POST_SLOT_API_ENDPOINTS.patch(postSlotId ?? 0), data);
      return response.data as GetPostSlotResponse;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [POST_SLOT_CACHE_KEY, postSlotId] });
      toast.success('Post Slot updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const data = computed(() => queryData.value);

  return {
    data,
    createPost,
    updatePost,
    isLoading: isFetching || isUpdating || isCreating,
  };
};
