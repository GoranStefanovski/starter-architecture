import type { DatatableColumns } from '@starter-core/dash-ui/src';

export const STORES_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: 'stores.datatable.logo',
    name: 'avatar',
    sortable: true,
  },
  {
    id: 1,
    label: 'stores.datatable.name',
    name: 'name',
    sortable: true,
  },
  {
    id: 2,
    label: 'stores.datatable.domain',
    name: 'domain',
    sortable: true,
  },
  {
    id: 3,
    label: 'stores.datatable.email',
    name: 'email',
    sortable: true,
  },
  {
    id: 4,
    label: 'stores.datatable.phone',
    name: 'phone',
    sortable: false,
  },
  {
    id: 5,
    label: 'stores.datatable.status',
    name: 'status',
  },
  {
    id: 6,
    label: 'strings.actions',
    name: 'actions',
  },
  {
    id: 7,
    label: 'strings.delete',
    name: 'delete',
  },
];
