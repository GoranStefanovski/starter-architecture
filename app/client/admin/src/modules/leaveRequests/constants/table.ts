import { DatatableColumns } from "@starter-core/dash-ui/src";

export const LEAVE_REQUESTS_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: "leaveRequests.datatable.slug",
    name: "slug",
    sortable: false,
  },
  {
    id: 1,
    label: "leaveRequests.datatable.name",
    name: "name",
    sortable: true,
  },
  {
    id: 2,
    label: "leaveRequests.datatable.is_paid",
    name: "is_paid",
    sortable: true,
  },
  {
    id: 6,
    label: "strings.actions",
    name: "actions",
  },
  {
    id: 7,
    label: "strings.delete",
    name: "delete",
  },
];
