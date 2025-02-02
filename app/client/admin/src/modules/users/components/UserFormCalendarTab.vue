<script lang="ts" setup>
  import { useI18n } from "vue-i18n";
  import axios from "axios";
  import { ref, onMounted, computed } from "vue";

  const { t } = useI18n();
  const props = defineProps(["userId"]);
  const leaveDays = ref([]);

  const fetchApprovedLeaveDays = async () => {
    try {
      const response = await axios.get("/leave_request/draw", {
        params: { userId: props.userId },
      });
      leaveDays.value = response.data;
      console.log(leaveDays)
    } catch (error) {
      console.error("Error fetching managers:", error);
    }
  };

  onMounted(() => {
    fetchApprovedLeaveDays();
  });
</script>
<template>
  <div class="kt-section">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">
        Leave Days:
      </h3>

    </div>
  </div>
</template>
