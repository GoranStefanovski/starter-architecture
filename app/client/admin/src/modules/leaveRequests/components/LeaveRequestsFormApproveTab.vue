<script lang="ts" setup>
  import axios from "axios";
  import { ref, onMounted, computed } from "vue";
  import { useI18n } from "vue-i18n";
  import { FormInput } from "@starter-core/dash-ui/src";
  import LeaveRequestsDropdown from "./LeaveRequestsDropdown.vue";
  import LeaveRequestsDropdownTypes from "./LeaveRequestsDropdownTypes.vue";

  const { t } = useI18n();
  const leaveTypes = ref([]);
  const managers = ref([]);
  const admins = ref([]);
  const userId = defineModel("userId", { required: true, type: Number });
  const leaveTypeId = defineModel("leaveTypeId", { required: true, type: Number });
  const startDate = defineModel("startDate", { required: true, type: String });                    
  const endDate = defineModel("endDate", { required: true, type: String });
  const reason = defineModel("reason", { required: true, type: String });
  const requestTo = defineModel("requestTo", { required: true, type: String });

  const props = defineProps(["user"]);

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

  const fetchAdmins = async () => {
    try {
      const response = await axios.get("/user/draw", {
        params: { search: "admin" },
      });
      admins.value = response.data.data;
    } catch (error) {
      console.error("Error fetching admins:", error);
    }
  };

  onMounted(() => {
    fetchLeaveTypes();
    fetchManagers();
    fetchAdmins();
  });
</script>
<template>
  <div class="kt-section">
    <div class="kt-section__body">
      <leave-requests-dropdown v-if="user.role == 1 || user.role == 2"  class="noClick" v-model:model="requestTo" :optionsData="admins" :readonly="true"/>
      <leave-requests-dropdown v-else v-model:model="requestTo"  class="noClick" :optionsData="managers" :readonly="true"/>
      
      <leave-requests-dropdown-types class="noClick" v-model:model="leaveTypeId" :optionsData="leaveTypes" :readonly="true"/>

      <div class="form-group form-input form-group--inline" readonly>
        <div class="form-group__column form-group__column--left form-group__column--inline">
          <label class="form-group__label" for="reason">Reason (optional)</label>
        </div>
        <div class="form-group__column form-group__column--right form-group__column--inline">
          <input name="reason" readonly class="form-input__input form-input__input--inline" type="text" v-model="reason">
        </div>
      </div>
      
      <div class="dates_wrapper">
        <div class="dates_from">
          <label class="form-group__label" for="startDate">Start date:</label>
          <input readonly type="date" id="startDate" name="startDate" v-model="startDate" />
        </div>

        <div>
          <label class="form-group__label" for="endDate">End date:</label>
          <input readonly type="date" id="endDate" name="endDate" v-model="endDate" />
        </div>  
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
  .dates_wrapper {
    display: flex;
    align-items: flex-start;

    .dates_from {
      margin-right: 100px;
    }
  }

  .noClick {
    pointer-events: none;
  }
</style>