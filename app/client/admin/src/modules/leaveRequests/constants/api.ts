export const LEAVE_REQUEST_API_ENDPOINTS = {
  get: (leaveRequestId: number) => `/leave_request/${leaveRequestId}`,
  create: "/leave_request/create",
  list: "/leave_request/all",
  approve: (leaveRequestId: number) => `/leave_request/${leaveRequestId}/approve`,
  decline: (leaveRequestId: number) => `/leave_request/${leaveRequestId}/decline`,
  patch: (leaveRequestId: number) => `/leave_request/${leaveRequestId}`,
  delete: (leaveRequestId: number) => `/leave_request/${leaveRequestId}/delete`,
  table: "leave_request/draw",
};

export const LEAVE_REQUESTS_QUERY_KEY = "leaveRequest-table";
