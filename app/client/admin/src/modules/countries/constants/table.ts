import { DatatableColumns } from "@starter-core/dash-ui/src";

export const COUNTRIES_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: "Country Code",
    name: "country_code",
    sortable: false,
  },
  {
    id: 1,
    label: "Name",
    name: "name",
    sortable: false,
  },
  {
    id: 2,
    label: "strings.actions",
    name: "actions",
  },
  {
    id: 3,
    label: "strings.delete",
    name: "delete",
  },
];
