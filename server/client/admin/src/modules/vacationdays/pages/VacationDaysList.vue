<script setup lang="ts">
  import { onMounted } from "vue";
  import { VacationDayDatatable } from "../components";
  import { PageWrapper } from "@/components";
  import { useRootStore } from "@/store/root";

  const { setBackUrl, setActiveClasses } = useRootStore();

  onMounted(() => {
    setBackUrl("/");
    setActiveClasses({
      main: "vacationDays",
      sub: "vacationDays",
      title: "vacationDays.title",
      hasFilters: "vacationDays",
    });
  });
</script>
<template>
  <PageWrapper>
    <VacationDayDatatable />
  </PageWrapper>
</template>
