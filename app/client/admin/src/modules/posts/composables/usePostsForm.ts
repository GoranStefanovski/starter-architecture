import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import axios from 'axios';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import { POST_API_ENDPOINTS, POSTS_TABLE_QUERY_KEY } from '../constants';
import type { PostFormItem, GetPostResponse, GetPostDataRowResponse } from '../types';
import { useUploadEventImage } from './useUploadEventImage';

const POST_CACHE_KEY = 'post';

export const usePostsForm = (postId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();
  const { uploadEventImage, isLoading: isUploadingEventImage } = useUploadEventImage({
    postId,
    onSuccess: async () => {
      void queryClient.invalidateQueries({ queryKey: [POST_CACHE_KEY, postId] });
      toast.success('Image has been updated!');
    },
  });

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [POST_CACHE_KEY, postId],
    queryFn: async (): Promise<GetPostResponse> => {
      const data = await axios.get(POST_API_ENDPOINTS.get(postId ?? 0));
      return data.data as GetPostResponse;
    },
    enabled: !!postId,
  });

  const { mutate: createPost, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: PostFormItem): Promise<GetPostResponse> => {
      const data = await axios.post(POST_API_ENDPOINTS.create, newUserData);
      return data.data as GetPostResponse;
    },
    onSuccess: async () => {
      toast.success('User saved!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updatePost, isPending: isUpdating } = useMutation({
    mutationFn: async (data: PostFormItem): Promise<GetPostResponse> => {
      const response = await axios.patch(POST_API_ENDPOINTS.patch(postId ?? 0), data);
      return response.data as GetPostResponse;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [POST_CACHE_KEY, postId] });
      toast.success('User updated!');
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: deletePost, isPending: isDeleting } = useMutation({
    mutationFn: async (postId: number) => {
      await axios.post(POST_API_ENDPOINTS.delete(postId));
    },
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: [POSTS_TABLE_QUERY_KEY] });
      toast.success('Event deleted!');
    },
    onError: () => {
      toast.error('Error deleting event!');
    },
  });

  const data = computed(() => queryData.value);

  return {
    data,
    createPost,
    updatePost,
    uploadEventImage,
    deletePost,
    isLoading: isFetching || isUpdating || isCreating || isUploadingEventImage,
  };
};
