import { useQuery, useMutation, useQueryClient } from "@tanstack/vue-query";
import axios from "axios";
import { computed } from "vue";
import { useToast } from "vue-toastification";
import { LEAVE_REQUEST_API_ENDPOINTS } from "../constants";
import type { LeaveRequestFormItem, GetLeaveRequestResponse } from "../types";

const LEAVE_REQUEST_CACHE_KEY = "leave_request";

export const useLeaveRequestsForm = (leaveRequestId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [LEAVE_REQUEST_CACHE_KEY, leaveRequestId],
    queryFn: async (): Promise<GetLeaveRequestResponse> => {
      const data = await axios.get(LEAVE_REQUEST_API_ENDPOINTS.get(leaveRequestId ?? 0));
      return data.data;
    },
    enabled: !!leaveRequestId,
  });

  const { mutate: createLeaveRequest, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: LeaveRequestFormItem): Promise<GetLeaveRequestResponse> => {
      const data = await axios.post(LEAVE_REQUEST_API_ENDPOINTS.create, newUserData);
      return data.data;
    },
    onSuccess: async () => {
      toast.success("Leave Request saved!");
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updateLeaveRequest, isPending: isUpdating } = useMutation({
    mutationFn: async (data: LeaveRequestFormItem): Promise<GetLeaveRequestResponse> => {
      const response = await axios.patch(
        LEAVE_REQUEST_API_ENDPOINTS.patch(leaveRequestId ?? 0),
        data,
      );
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [LEAVE_REQUEST_CACHE_KEY, leaveRequestId] });
      toast.success("Leave Request updated!");
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: approveLeaveRequest, isPending: isConfrirming } = useMutation({
    mutationFn: async (data: LeaveRequestFormItem): Promise<GetLeaveRequestResponse> => {
      const response = await axios.post(
        LEAVE_REQUEST_API_ENDPOINTS.approve(leaveRequestId ?? 0),
        data,
      );
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [LEAVE_REQUEST_CACHE_KEY, leaveRequestId] });
      toast.success("Leave Request updated!");
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: declineLeaveRequest, isPending: isDeclining } = useMutation({
    mutationFn: async (data: LeaveRequestFormItem): Promise<GetLeaveRequestResponse> => {
      const response = await axios.post(
        LEAVE_REQUEST_API_ENDPOINTS.decline(leaveRequestId ?? 0),
        data,
      );
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [LEAVE_REQUEST_CACHE_KEY, leaveRequestId] });
      toast.success("Leave Request updated!");
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });


  const data = computed(() => queryData.value);

  return {
    data,
    createLeaveRequest,
    updateLeaveRequest,
    approveLeaveRequest,
    declineLeaveRequest,
    isLoading: isFetching || isUpdating || isCreating || isConfrirming || isDeclining,
  };
};
