export const VACATION_DAY_API_ENDPOINTS = {
  get: (vacationdayId: number) => `/vacationday/${vacationdayId}`,
  create: "/vacationday/create",
  patch: (vacationdayId: number) => `/vacationday/${vacationdayId}`,
  uploadAvatar: (vacationdayId: number) => `/vacationday/avatar/${vacationdayId}`,
  table: "vacationday/draw",
};

export const VACATION_DAYS_TABLE_QUERY_KEY = "vacationdays-table";
