import { useQuery, useMutation, useQueryClient } from "@tanstack/vue-query";
import axios from "axios";
import { computed } from "vue";
import { useToast } from "vue-toastification";
import { LEAVE_TYPE_API_ENDPOINTS } from "../constants";
import type { LeaveTypeFormItem, GetLeaveTypeResponse } from "../types";

const LEAVE_TYPE_CACHE_KEY = "leave_type";

export const useLeaveTypesForm = (leaveTypeId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [LEAVE_TYPE_CACHE_KEY, leaveTypeId],
    queryFn: async (): Promise<GetLeaveTypeResponse> => {
      const data = await axios.get(LEAVE_TYPE_API_ENDPOINTS.get(leaveTypeId ?? 0));
      return data.data;
    },
    enabled: !!leaveTypeId,
  });

  const { mutate: createLeaveType, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: LeaveTypeFormItem): Promise<GetLeaveTypeResponse> => {
      const data = await axios.post(LEAVE_TYPE_API_ENDPOINTS.create, newUserData);
      return data.data;
    },
    onSuccess: async () => {
      toast.success("Leave Type saved!");
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updateLeaveType, isPending: isUpdating } = useMutation({
    mutationFn: async (data: LeaveTypeFormItem): Promise<GetLeaveTypeResponse> => {
      const response = await axios.patch(
        LEAVE_TYPE_API_ENDPOINTS.patch(leaveTypeId ?? 0),
        data,
      );
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [LEAVE_TYPE_CACHE_KEY, leaveTypeId] });
      toast.success("Leave Type updated!");
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });


  const data = computed(() => queryData.value);

  return {
    data,
    createLeaveType,
    updateLeaveType,
    isLoading: isFetching || isUpdating || isCreating,
  };
};
