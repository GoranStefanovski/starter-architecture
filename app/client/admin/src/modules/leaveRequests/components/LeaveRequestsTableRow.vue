<script setup lang="ts">
  import { IconTrash, IconEdit } from "@starter-core/icons";
  import { useAuth } from "@websanova/vue-auth/src/v3.js";
  import { ref } from "vue";
  import type { GetLeaveRequestResponse } from "../types";
  import LeaveRequestStatusBadge from "./LeaveRequestStatusBadge.vue";
  import ConfirmDialog from "@/components/ConfirmDialog/ConfirmDialog.vue";
  import {
    DashButton,
    DashLink,
    TableColumn,
    TableRow,
  } from "@starter-core/dash-ui/src";

  interface LeaveRequestsTableRowProps {
    leaveRequest: GetLeaveRequestResponse;
    isEvenRow: boolean;
    deleteLeaveRequest: (id: number) => Promise<void>;
    downloadLeaveRequestPDF: (file_name: string) => Promise<void>;
    documents: Array<any>;
    isAllPage: boolean;
  }

  const auth = useAuth();
  const { leaveRequest, isEvenRow, deleteLeaveRequest, downloadLeaveRequestPDF, documents, isAllPage } =
    defineProps<LeaveRequestsTableRowProps>();

  const showConfirmDialog = ref(false);

  const confirmDelete = () => {
    deleteLeaveRequest(leaveRequest.id);
    showConfirmDialog.value = false;
  };

  const confirmDownload = (string: string) => {
    downloadLeaveRequestPDF(string);
    showConfirmDialog.value = false;
  };
</script>

<template>
  <template v-if="true">
    <TableRow :section="'body'" :is-even="isEvenRow">
      <TableColumn>
        {{ leaveRequest.leaveType.name }}
      </TableColumn>

      <TableColumn>
        <span v-if="isAllPage">
          {{ leaveRequest.user.first_name }}
          {{ leaveRequest.user.last_name }}
        </span>
        <span v-else>
          -
        </span>
        
      </TableColumn>

      <TableColumn>
        {{ leaveRequest.requestToUser.first_name }}
        {{ leaveRequest.requestToUser.last_name }}
      </TableColumn>

      <TableColumn>
        <LeaveRequestStatusBadge :status="leaveRequest.is_confirmed" />
      </TableColumn>

      <TableColumn>
        {{ leaveRequest.start_date }}
      </TableColumn>

      <TableColumn>
        {{ leaveRequest.end_date ? leaveRequest.end_date : "Single Day" }}
      </TableColumn>

      <TableColumn>
        {{ leaveRequest.days }}
      </TableColumn>

      <TableColumn>
        <div v-if="documents.length">
          <div v-for="doc in documents" :key="doc.id">
            <p class="pdf" v-if="doc.leave_request_id === leaveRequest.id" @click="confirmDownload(doc.file_name)">
              {{ doc.file_name }}
            </p>
          </div>
        </div>
        <div v-else>
          -
        </div>
      </TableColumn>

      <TableColumn>
        <DashLink
          v-if="
            auth.user().permissions_array.includes('delete_requests') &&
            (((leaveRequest.is_confirmed == 0 || leaveRequest.is_confirmed == 1) && auth.user().role !== 1) ||
            (auth.user().role == 1))
          "
          :to="{
            name: 'edit.leave_request',
            params: { leaveRequestId: leaveRequest.id },
          }"
          theme="primary"
          theme-mod="outline-hover"
          :icon="IconEdit"
        >
          {{ $t("buttons.edit") }}
        </DashLink>
        <span v-else>-</span>
      </TableColumn>

      <TableColumn>
        <DashButton
          v-if="
            auth.user().permissions_array.includes('delete_requests') &&
            (((leaveRequest.is_confirmed == 0 || leaveRequest.is_confirmed == 1) && auth.user().role !== 1) ||
            (auth.user().role == 1))
          "
          :icon="IconTrash"
          theme="danger"
          size="sm"
          @click="showConfirmDialog = true"
          is-pill
          is-icon
        />
      </TableColumn>
    </TableRow>

    <!-- Confirmation Dialog -->
    <ConfirmDialog
      :show="showConfirmDialog"
      message="Are you sure you want to delete this leave request?"
      @confirm="confirmDelete"
      @close="showConfirmDialog = false"
    />
  </template>
</template>
<style>
.pdf:hover {
 cursor: pointer;
 border-bottom: 0.3px solid black;
}
</style>