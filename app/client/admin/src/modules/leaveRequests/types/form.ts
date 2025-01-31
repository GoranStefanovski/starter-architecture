export interface LeaveRequestFormItem {
  id?: number;
  user_id?: number;
  leave_type_id?: number;
  start_date?: Date;
  end_date?: Date;
  status?: string;
  reason?: string;
  request_to?: string;
  approved_by?: string;
}
