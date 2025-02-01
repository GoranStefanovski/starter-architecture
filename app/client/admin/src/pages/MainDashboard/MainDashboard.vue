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

  // const categories = ref([]);
  const leaveTypes = ref([]);
  const isLoading = ref(false);
  const { setActiveClasses } = useRootStore();
  onMounted(() => {
    fetchLeaveTypes();
    isLoading.value = true;
    setActiveClasses({
      main: "item_dashboard",
      sub: "item_dashboard",
      title: "strings.dashboard",
    });
  });

  const fetchLeaveTypes = async () => {
    try {
      const response = await axios.get("/leave_type/all");
      leaveTypes.value = response.data;
    } catch (error) {
      console.error("Error fetching leave types:", error);
    }
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
      <div class="col-md-4"></div>
      <div class="col-md-4"></div>
      <!-- <div class="col-md-3">
        <AccordionContent>
          <AccordionItem
            label="Product inventory"
            id="product-inventory"
            :icon="IconChartpie"
          >
            Vero laborum esse debitis libero veniam ullam placeat molestias
            deleniti distinctio magnam? In, odio alias? Possimus labore delectus
            recusandae.
          </AccordionItem>
          <AccordionItem
            label="Order statistics"
            id="order-statistics"
            :icon="IconLibrary"
          >
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, aut
            molestiae.
          </AccordionItem>
          <AccordionItem
            label="eCommerce reports"
            id="ecommerce-reports"
            :icon="IconDollar"
          >
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, aut
            molestiae.
          </AccordionItem>
        </AccordionContent>
      </div> -->
    </div>
  </PageWrapper>
</template>
