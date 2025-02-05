<script setup lang="ts">
  import {
    IconAirpods,
    IconChartpie,
    IconDollar,
    IconLibrary,
  } from "@starter-core/icons";
  import { ref, onMounted } from "vue";
  import { PageWrapper } from "@/components";
  // import { get } from "@/services/HTTP";
  import { useRootStore } from "@/store/root";
  import {
    PortletComponent,
    PortletBody,
    PortletHead,
    PortletHeadLabel,
    ContentLoader,
    AccordionContent,
    AccordionItem,
  } from "@starter-core/dash-ui/src";
  import axios from "axios";

  import {
    DashLink,
  } from "@starter-core/dash-ui/src";
import { leaveRequest } from "@/modules/leaveRequests/constants";

  // const categories = ref([]);
  const leaveTypes = ref([]);
  const users = ref([]);
  const leaveRequests = ref([]);
  const isLoading = ref(false);
  const { setActiveClasses } = useRootStore();
  onMounted(() => {
    fetchLeaveTypes();
    fetchUsers();
    fetchRequests();
    isLoading.value = true;
    setActiveClasses({
      main: "item_dashboard",
      sub: "item_dashboard",
      title: "strings.dashboard",
    });
  });

  const fetchUsers = async () => {
    try {
      const response = await axios.get("/user/all");
      users.value = response.data;
    } catch (error) {
      console.error("Error fetching leave types:", error);
    }
  };

  const fetchRequests = async () => {
    try {
      const response = await axios.get("/leave_request/draw", {
        params: { isPending: true }
      });
      leaveRequests.value = response.data.data;
    } catch (error) {
      console.error("Error fetching leave types:", error);
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
</script>
<template>
  <PageWrapper>
    <div class="row">
      <div class="col-md-4 mb-4">
        <PortletComponent isBordered>
          <PortletHead>
            <PortletHeadLabel>
              Leave Types
            </PortletHeadLabel>
          </PortletHead>
          <PortletBody>
            <table>
              <tr>
                <th>ID</th>
                <th>Name</th>
              </tr>
              <tr v-for="type, index in leaveTypes" :key="index">
                <td>{{ type.id }}.</td>
                <td>{{ type.name }}</td>
              </tr>
            </table>
          </PortletBody>
        </PortletComponent>
      </div>
      <div class="col-md-4">
        <PortletComponent isBordered>
          <PortletHead>
            <PortletHeadLabel>
              Paid Leaves Left
            </PortletHeadLabel>
          </PortletHead>
          <PortletBody>
            <table>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Days Left</th>
              </tr>
              <tr v-for="user, index in users" :key="index">
                <td>{{ index + 1 }}.</td>
                <td>{{ user.first_name }}</td>
                <td>{{ user.paid_leaves_left }}</td>
              </tr>
            </table>
          </PortletBody>
        </PortletComponent>
      </div>
      <div class="col-md-4">
        <PortletComponent isBordered>
          <PortletHead>
            <PortletHeadLabel>
              Pending Leave Requests
            </PortletHeadLabel>
          </PortletHead>
          <PortletBody>
            <table>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Link To Approval</th>
              </tr>
              <tr v-for="leave, index in leaveRequests" :key="index">
                <td>{{ index + 1}}.</td>
                <td>{{ getUserFullName(leave.user_id) }}</td>
                <td>
                  <a :href="`/admin/leave_request/${leave.id}/confirmation`">Edit</a>
                </td>
              </tr>
            </table>
          </PortletBody>
        </PortletComponent>
      </div>
    </div>
  </PageWrapper>
</template>
