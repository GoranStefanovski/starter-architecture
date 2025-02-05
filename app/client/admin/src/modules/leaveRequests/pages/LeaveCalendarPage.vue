<script setup lang="ts">
import { onMounted, ref, computed } from "vue";
import axios from "axios";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import { PageWrapper } from "@/components";
import { useRootStore } from "@/store/root";

// Store
const { setBackUrl } = useRootStore();

// Set back URL when the page is mounted
onMounted(() => {
  setBackUrl("/");
});

// Reactive References
const leaveDays = ref([]);
const nationalHolidays = ref([]);
const users = ref([]);
const leaveTypes = ref([]);

// Fetch Leave Days for All Users (Only Approved)
const fetchAllApprovedLeaveDays = async () => {
  try {
    const response = await axios.get("/leave_request/draw", {
      params: { isApproved: true },
    });
    leaveDays.value = response.data.data;
  } catch (error) {
    console.error("Error fetching leave requests:", error);
  }
};

const fetchAllNationalHolidays = async () => {
  try {
    const response = await axios.get("/national_holiday/all");
    nationalHolidays.value = response.data;
  } catch (error) {
    console.error("Error fetching national holidays:", error);
  }
};

// Fetch Users
const fetchUsers = async () => {
  try {
    const response = await axios.get("/user/draw");
    users.value = response.data.data;
  } catch (error) {
    console.error("Error fetching users:", error);
  }
};

const fetchLeaveTypes = async () => {
    try {
      const response = await axios.get("/leave_type/all");
      leaveTypes.value = response.data;
    } catch (error) {
      console.error("Error fetching leave types:", error);
    }
  };


const getUserFullName = (userId: number) => {
  const user = users.value.find((u: any) => u.id === userId);
  return user ? `${user.first_name} ${user.last_name}` : "Unknown User";
};

const getLeaveTypeColor = (id: number) => {
  const leaveType = leaveTypes.value.find((u: any) => u.id === id);
  return leaveType ? leaveType.color  : "Unknown Leave Type";
};

const calendarEvents = computed(() => {
  const leaveEvents = leaveDays.value.map((leave: any) => ({
    title: getUserFullName(leave.user_id),
    start: leave.start_date,
    end: leave.end_date || leave.start_date,
    backgroundColor: getLeaveTypeColor(leave.leave_type_id),
    textColor: "#fff",
  }));

  const holidayEvents = nationalHolidays.value.map((holiday: any) => ({
    title: holiday.country + 'n National Holiday',
    start: holiday.date,
    end: holiday.date,
    backgroundColor: "#6326F2", // Black color for holidays
    textColor: "#fff",
  }));

  return [...leaveEvents, ...holidayEvents];
});

// Calendar Options
const calendarOptions = computed(() => ({
  plugins: [dayGridPlugin],
  initialView: "dayGridMonth",
  weekends: true,
  events: calendarEvents.value,
}));

// Fetch Data on Mount
onMounted(() => {
  fetchAllApprovedLeaveDays();
  fetchUsers();
  fetchAllNationalHolidays();
  fetchLeaveTypes();
});
</script>

<template>
  <PageWrapper>
    <div style="width: 65%;">
      <FullCalendar :options="calendarOptions" />
    </div>
  </PageWrapper>
</template>

<style scoped>
.page-title {
  margin-bottom: 20px;
  font-size: 24px;
  font-weight: bold;
  color: #343a40;
  text-align: center;
}

.fc-event {
  border-radius: 4px;
  padding: 2px 4px;
  font-weight: bold;
}
</style>
