export const USER_PERMISSIONS = {
  readVacationDays: "read_vacation_days",
  writeVacationDays: "write_vacation_days",
  deleteVacationDays: "delete_vacation_days",
} as const;

export const USER_ROLES = {
  admin: 1,
  editor: 2,
  collaborator: 3,
} as const;
