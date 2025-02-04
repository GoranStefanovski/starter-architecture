<script lang="ts" setup>
import { useI18n } from "vue-i18n";
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";

// Internationalization
const { t } = useI18n();

// Props
const props = defineProps<{ userId: number }>();

// Reactive References
const leaveDays = ref([]);
const leaveTypes = ref([]);

// Fetch Approved Leave Days
const fetchApprovedLeaveDays = async () => {
  try {
    const response = await axios.get("/leave_request/draw", {
      params: { userId: props.userId },
    });
    leaveDays.value = response.data.data;
  } catch (error) {
    console.error("Error fetching leave requests:", error);
  }
};

// Fetch Leave Types
const fetchLeaveTypes = async () => {
  try {
    const response = await axios.get("/leave_type/all");
    leaveTypes.value = response.data;
  } catch (error) {
    console.error("Error fetching leave types:", error);
  }
};

// Get Leave Type Name by ID
const getNameLeaveType = (id: number) => {
  const leaveType = leaveTypes.value.find((type) => type.id === id);
  return leaveType ? leaveType.name : "Unknown Leave Type";
};

const getNameLeaveColor = (id: number) => {
  const leaveType = leaveTypes.value.find((type) => type.id === id);
  return leaveType ? leaveType.color : "Unknown Leave Type";
};

// Map Leave Days to Calendar Events
const calendarEvents = computed(() =>
  leaveDays.value.map((leave: any) => ({
    title: getNameLeaveType(leave.leave_type_id),
    start: leave.start_date,
    end: leave.end_date || leave.start_date, // Use start_date if end_date is missing
    backgroundColor: getNameLeaveColor(leave.leave_type_id), // Green for approved, red for others
    textColor: "#fff",
  }))
);

// Calendar Options
const calendarOptions = computed(() => ({
  plugins: [dayGridPlugin],
  initialView: "dayGridMonth",
  weekends: true,
  events: calendarEvents.value,
}));

// Lifecycle Hook
onMounted(() => {
  fetchApprovedLeaveDays();
  fetchLeaveTypes();
});
</script>

<template>
  <div class="kt-section">
    <div class="kt-section__body">
      <div style="width: 65%; height: 70%;">
        <FullCalendar :options="calendarOptions" />
      </div>
    </div>
  </div>
</template>

<style scoped>
.kt-section {
  padding: 20px;
}

.kt-section__title {
  margin-bottom: 20px;
  color: #343a40;
}

.fc-event {
  border-radius: 4px;
  padding: 2px 4px;
  font-weight: bold;
}
</style>
