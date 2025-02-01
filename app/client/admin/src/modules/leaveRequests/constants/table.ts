import { DatatableColumns } from "@starter-core/dash-ui/src";

export const LEAVE_REQUESTS_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: "Status",
    name: "status",
    sortable: false,
  },
  {
    id: 1,
    label: "From",
    name: "start_date",
    sortable: true,
  },
  {
    id: 2,
    label: "To",
    name: "end_date",
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
