import type { DatatableColumns } from '@starter-core/dash-ui/src';

export const VENUES_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: 'venues.datatable.avatar',
    name: 'avatar',
    sortable: false,
  },
  {
    id: 1,
    label: 'venues.datatable.name',
    name: 'name',
    sortable: true,
  },
  {
    id: 2,
    label: 'venues.datatable.address',
    name: 'address',
    sortable: true,
  },
  {
    id: 3,
    label: 'venues.datatable.status',
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
