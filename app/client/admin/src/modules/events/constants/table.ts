import type { DatatableColumns } from '@starter-core/dash-ui/src';

export const EVENTS_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: 'events.datatable.avatar',
    name: 'avatar',
    sortable: false,
  },
  {
    id: 1,
    label: 'events.datatable.name',
    name: 'name',
    sortable: true,
  },
  {
    id: 2,
    label: 'events.datatable.address',
    name: 'address',
    sortable: true,
  },
  {
    id: 3,
    label: 'events.datatable.status',
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
