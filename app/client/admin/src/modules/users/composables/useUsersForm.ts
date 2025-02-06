import { useQuery, useMutation, useQueryClient } from "@tanstack/vue-query";
import axios from "axios";
import { computed, ref } from "vue";
import { useToast } from "vue-toastification";
import { USER_API_ENDPOINTS } from "../constants";
import type { UserFormItem, GetUserResponse } from "../types";
import { useRouter } from 'vue-router';

const USER_CACHE_KEY = "user";

export const useUsersForm = (userId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();
  const router = useRouter();
  const manualLoading = ref(false);

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [USER_CACHE_KEY, userId],
    queryFn: async (): Promise<GetUserResponse> => {
      const data = await axios.get(USER_API_ENDPOINTS.get(userId ?? 0));
      return data.data;
    },
    enabled: !!userId,
  });

  const { mutate: createUser, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: UserFormItem): Promise<GetUserResponse> => {
      manualLoading.value = true;
      const data = await axios.post(USER_API_ENDPOINTS.create, newUserData);
      return data.data;
    },
    onSuccess: async () => {
      toast.success("User saved!");
      router.push({ name: "users" });
      manualLoading.value = false;
    },
    onError: (error) => {
      manualLoading.value = false;
      toast.error(error.message);
    },
  });

  const { mutate: updateUser, isPending: isUpdating } = useMutation({
    mutationFn: async (data: UserFormItem): Promise<GetUserResponse> => {
      manualLoading.value = true;
      const response = await axios.patch(
        USER_API_ENDPOINTS.patch(userId ?? 0),
        data,
      );
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, userId] });
      toast.success("User updated!");
      manualLoading.value = false;
    },
    onError: (error) => {
      manualLoading.value = false;
      toast.error(error.message);
    },
  });

  const { mutate: uploadAvatar, isPending: isUploadingAvatar } = useMutation({
    mutationFn: async (file: File): Promise<GetUserResponse> => {
      manualLoading.value = true;
      const formData = new FormData();
      formData.append("avatar", file);

      const response = await axios.post(
        USER_API_ENDPOINTS.uploadAvatar(userId ?? 0),
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        },
      );
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [USER_CACHE_KEY, userId] });
      toast.success("Image has been updated!");
      manualLoading.value = false;
    },
    onError: (error) => {
      manualLoading.value = false;
      toast.error(error.message);
    },
  });

  const data = computed(() => queryData.value);

  return {
    data,
    createUser,
    updateUser,
    uploadAvatar,
    isLoading: manualLoading,
  };
};
