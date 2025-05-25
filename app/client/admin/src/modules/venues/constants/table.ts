import type { DatatableColumns } from '@starter-core/dash-ui/src';

export const USERS_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: 'users.datatable.avatar',
    name: 'avatar',
    sortable: false,
  },
  {
    id: 1,
    label: 'users.datatable.name',
    name: 'name',
    sortable: true,
  },
  {
    id: 2,
    label: 'users.datatable.address',
    name: 'address',
    sortable: true,
  },
  {
    id: 3,
    label: 'users.datatable.status',
    name: 'status',
  },
  {
    id: 4,
    label: 'strings.actions',
    name: 'actions',
  },
  {
    id: 5,
    label: 'strings.delete',
    name: 'delete',
  },
];
