import type { DatatableColumns } from '@starter-core/dash-ui/src';

export const POSTS_DATATABLE_COLUMNS: DatatableColumns = [
  {
    id: 0,
    label: 'posts.datatable.name',
    name: 'name',
    sortable: true,
  },
  {
    id: 1,
    label: 'posts.datatable.post_slot',
    name: 'boosted',
  },
  {
    id: 1,
    label: 'posts.datatable.boosted',
    name: 'boosted',
  },
  {
    id: 2,
    label: 'posts.datatable.status',
    name: 'status',
  },
  {
    id: 3,
    label: 'strings.actions',
    name: 'actions',
  },
  {
    id: 4,
    label: 'strings.delete',
    name: 'delete',
  },
];
