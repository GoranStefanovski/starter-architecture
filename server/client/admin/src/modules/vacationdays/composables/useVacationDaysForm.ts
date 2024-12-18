import { useQuery, useMutation, useQueryClient } from "@tanstack/vue-query";
import axios from "axios";
import { computed } from "vue";
import { useToast } from "vue-toastification";
import { VACATION_DAY_API_ENDPOINTS } from "../constants";
import type { VacationDayFormItem, GetVacationDayResponse } from "../types";

const VACATION_DAY_CACHE_KEY = "vacationDay";
const COMMON_CACHE_KEY = "common"
const USER_CACHE_KEY = "user"
export const useVacationDaysForm = (vacationDayId?: number) => {
  const queryClient = useQueryClient();
  const toast = useToast();

  const { isLoading: isFetching, data: queryData } = useQuery({
    queryKey: [VACATION_DAY_CACHE_KEY, vacationDayId],
    queryFn: async (): Promise<GetVacationDayResponse> => {
      const data = await axios.get(VACATION_DAY_API_ENDPOINTS.get(vacationDayId ?? 0));
      return data.data;
    },
    enabled: !!vacationDayId,
  });
    // Fetch All Day Types
  const { isLoading: isDayTypesFetching, data: dayTypesData } = useQuery({
    queryKey: [COMMON_CACHE_KEY, "daytypes"],
    queryFn: async () => {
      const response = await axios.get("/common/daytypes/all"); 
      return response.data;
    },
  }); 
  // Fetch Handlers
  const { isLoading: isHandlersFetching, data: handlersData } = useQuery({
    queryKey: [USER_CACHE_KEY, "handlers"],
    queryFn: async () => {
      const response = await axios.get("/user/handlers"); 
      return response.data;
    },
  });
  const { mutate: requestVacationDay, isPending: isCreating } = useMutation({
    mutationFn: async (newUserData: VacationDayFormItem): Promise<GetVacationDayResponse> => {
      const response = await axios.post(VACATION_DAY_API_ENDPOINTS.create, newUserData);
      return response.data;
    },
    onSuccess: async () => {
      toast.success("Vacation Day Requested!");
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const { mutate: updateRequestVacationDay, isPending: isUpdating } = useMutation({
    mutationFn: async (data: VacationDayFormItem): Promise<GetVacationDayResponse> => {
      const response = await axios.patch(
        VACATION_DAY_API_ENDPOINTS.patch(vacationDayId ?? 0),
        data,
      );
      return response.data;
    },
    onSuccess: async () => {
      queryClient.invalidateQueries({ queryKey: [VACATION_DAY_CACHE_KEY, vacationDayId] });
      toast.success("Vacation Day Updated!");
    },
    onError: (error) => {
      toast.error(error.message);
    },
  });

  const data = computed(() => queryData.value);

  const dayTypes = computed(() => dayTypesData.value);

  const handlers = computed(() => handlersData.value);
  return {
    data,
    dayTypes,
    handlers,
    requestVacationDay,
    updateRequestVacationDay,
    isLoading: isFetching || isUpdating || isCreating || isDayTypesFetching || isHandlersFetching,
  };
};
