<script setup lang="ts">
  import { useRoute, useRouter } from "vue-router";
  import { PortletBody } from "../Portlet";

  const router = useRouter();
  const route = useRoute();

  const handleSearch = (event: InputTextEvent) => {
    router.push({
      path: route.path,
      query: {
        ...route.query,
        search: event.target.value,
      },
    });
  };

  const clearFilter = () => {
    router.push({
      path: route.path,
    });
  }

  const props = defineProps<{
        options?: Array<any>;
        optionsLabel?: String;
    }>();
</script>

<template>
  <PortletBody>
    <!--begin: Search Form -->
    <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
      <div class="row align-items-center">
        <div class="col-xl-8 order-2 order-xl-1">
          <div class="row align-items-center">
            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
              <div class="kt-input-icon kt-input-icon--left">
                <input
                  v-on:keyup.enter="handleSearch"
                  type="text"
                  class="form-control"
                  placeholder="Search..."
                  name="search"
                />
                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                  <span>
                    <i class="las la-search" />
                  </span>
                </span>
              </div>
            </div>

            <div v-if="props.options" class="col-md-4 kt-margin-b-20-tablet-and-mobile">
              <div class="kt-form__group kt-form__group--inline">
                <div class="kt-form__label">
                  <label>{{ props.optionsLabel }}</label>
                </div>
                <div class="kt-form__control">
                  <select
                    v-on:input="handleSearch"
                    id="kt_form_status"
                    class="form-control bootstrap-select"
                  >
                    <option v-for="option, index in options" :key="index" :value="option.value">{{ option.name }}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
              <div class="kt-form__group kt-form__group--inline">
                <div v-on:click="clearFilter" class="kt-form__label">
                  <div class="clear_filters">Clear Filters</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 order-1 order-xl-2 kt-align-right">
          <a href="#" class="btn btn-default kt-hidden">
            <i class="la la-cart-plus" /> New Order
          </a>
          <div
            class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"
          />
        </div>
      </div>
    </div>
    <!--end: Search Form -->
  </PortletBody>
</template>
<style scoped lang="scss">
.clear_filters {
  font-weight: bold;
  &:hover {
    font-weight: bolder;
    cursor: pointer;
  }
}
</style>