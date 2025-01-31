<script lang="ts" setup>
  import axios from "axios";
  import { ref, onMounted, computed } from "vue";
  import { useI18n } from "vue-i18n";
  import { FormInput } from "@starter-core/dash-ui/src";

  const { t } = useI18n();
  const leaveTypes = ref([]);
  const managers = ref([]);
  const userId = defineModel("userId", { required: true, type: Number });
  const leaveTypeId = defineModel("leaveTypeId", { required: true, type: Number });
  const startDate = defineModel("startDate", { required: true, type: Date });
  const endDate = defineModel("endDate", { required: true, type: Date });
  const reason = defineModel("reason", { required: true, type: String });
  const requestTo = defineModel("requestTo", { required: true, type: String });



  const fetchLeaveTypes = async () => {
    try {
      const response = await axios.get("/leave_type/all");
      leaveTypes.value = response.data;
    } catch (error) {
      console.error("Error fetching leave types:", error);
    }
  };

  const fetchManagers = async () => {
    try {
      const response = await axios.get("/user/draw", {
        params: { search: "manager" },
      });
      managers.value = response.data.data;
    } catch (error) {
      console.error("Error fetching managers:", error);
    }
  };

  onMounted(() => {
    fetchLeaveTypes();
    fetchManagers();
  });
</script>
<template>
<div class="kt-section kt-section--first">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">
        {{ t("leaveRequests.leaveRequest_status") }}:
      </h3>
    </div>
  </div>

  <div
    class="kt-separator kt-separator--border-dashed kt-separator--space-lg"
  ></div>

  <div class="kt-section">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">Request:</h3>
      <form-input
        v-model="reason"
        name="reason"
        :label="t('leaveRequests.reason.label')"
        is-inline
      />
      <div>
        <label for="startDate">Start date:</label>
        <input type="date" id="startDate" name="startDate" v-model="startDate" />
      </div>  
      <div>
        <label for="endDate">End date:</label>
        <input type="date" id="endDate" name="endDate" v-model="endDate" />
      </div>  
      <div>
        <label for="leaveType">Leave Type:</label>
        <select id="leaveType" v-model="leaveTypeId" placeholder="Select leave type">
          <option v-for="(type, index) in leaveTypes" :key="index" :value="type.id">
            {{ type.name }}
          </option>
        </select>
      </div>
      <div>
        <label for="manager">Assign to Manager:</label>
        <select id="manager" v-model="requestTo">
          <option v-for="(manager, index) in managers" :key="index" :value="manager.id">
            {{ manager.first_name }} {{ manager.last_name }}
          </option>
        </select>
      </div>
    </div>
  </div>
</template>
