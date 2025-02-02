import { DatatableColumns } from "@starter-core/dash-ui/src";

export const LEAVE_TYPES_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: "Slug",
    name: "slug",
    sortable: false,
  },
  {
    id: 1,
    label: "Name",
    name: "name",
    sortable: true,
  },
  {
    id: 2,
    label: "Color",
    name: "color",
    sortable: true,
  },
  {
    id: 3,
    label: "strings.actions",
    name: "actions",
  },
  {
    id: 4,
    label: "strings.delete",
    name: "delete",
  },
];
