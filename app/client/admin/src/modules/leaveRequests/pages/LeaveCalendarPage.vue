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
const users = ref([]);

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

// Fetch Users
const fetchUsers = async () => {
  try {
    const response = await axios.get("/user/draw");
    users.value = response.data.data;
  } catch (error) {
    console.error("Error fetching users:", error);
  }
};

// Helper function to get user's full name
const getUserFullName = (userId: number) => {
  const user = users.value.find((u: any) => u.id === userId);
  return user ? `${user.first_name} ${user.last_name}` : "Unknown User";
};

// Map Leave Days to Calendar Events
const calendarEvents = computed(() =>
  leaveDays.value.map((leave: any) => ({
    title: getUserFullName(leave.user_id), // Get full name using user_id
    start: leave.start_date,
    end: leave.end_date || leave.start_date,
    backgroundColor: "#505ae2", // Default gray color
    textColor: "#fff",
    textFontSize: '24px'
  }))
);

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
