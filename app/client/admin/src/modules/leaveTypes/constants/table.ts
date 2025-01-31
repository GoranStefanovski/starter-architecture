import { DatatableColumns } from "@starter-core/dash-ui/src";

export const LEAVE_TYPES_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: "leaveTypes.datatable.slug",
    name: "slug",
    sortable: false,
  },
  {
    id: 1,
    label: "leaveTypes.datatable.name",
    name: "name",
    sortable: true,
  },
  {
    id: 2,
    label: "leaveTypes.datatable.is_paid",
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
