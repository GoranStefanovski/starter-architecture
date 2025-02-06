import { DatatableColumns } from "@starter-core/dash-ui/src";

export const LEAVE_REQUESTS_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: "Leave Type",
    name: "leave_type",
    sortable: false,
  },
  {
    id: 1,
    label: "Assigned To",
    name: "request_to",
    sortable: false,
  },
  {
    id: 2,
    label: "Status",
    name: "status",
    sortable: false,
  },
  {
    id: 3,
    label: "From (Date)",
    name: "start_date",
    sortable: true,
  },
  {
    id: 4,
    label: "To (Date)",
    name: "end_date",
    sortable: true,
  },
  {
    id: 5,
    label: "strings.actions",
    name: "actions",
  },
  {
    id: 6,
    label: "strings.delete",
    name: "delete",
  },
];
