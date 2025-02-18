<script lang="ts" setup>
  import axios from "axios";
  import { ref, onMounted, computed } from "vue";
  import { useI18n } from "vue-i18n";
  import { useLeaveRequestsForm } from "../../leaveRequests/composables/useLeaveRequestsForm";

  const { t } = useI18n();
  const props = defineProps(["userId"]);
  const documents = ref([]);
  const { downloadLeaveRequestPDF } = useLeaveRequestsForm();

  // Fetch approved leave requests
  const fetchUserDocuments = async () => {
    try {
      const response = await axios.get("/document/draw", {
        params: { userId: props.userId },
      });
      documents.value = response.data.data;
    } catch (error) {
      console.error("Error fetching leave requests:", error);
    }
  };

  const downloadPdf = (file_name: string) => {
    downloadLeaveRequestPDF(file_name);
  };

  onMounted(() => {
    fetchUserDocuments();
  });
</script>

<template>
  <div class="kt-section">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">Documents:</h3>
      <ul class="documents_list_wrapper">
        <li
          v-for="document in documents"
          :key="document.id"
          @click="downloadPdf(document.file_name)"
        >
          {{ document.file_name }}
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped lang="scss">
  .documents_list_wrapper {
    display: flex;
    flex-direction: column-reverse;

    & > li {
      margin-bottom: 15px;
      font-weight: bold;

      &:hover {
        font-weight: bolder;
        cursor: pointer;
      }
    }
  }
</style>
