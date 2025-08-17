<script lang="ts" setup>
  import axios from 'axios';
  import { ref, onMounted } from 'vue';
  import { useI18n } from 'vue-i18n';
  import UserFormAvatar from '@/modules/posts/components/UserFormAvatar.vue';
  import { FormInput } from '@starter-core/dash-ui/src';
  import '@vuepic/vue-datepicker/dist/main.css';
  import './EventFormBasicInfo.scss';

  type EmitsType = {
    (event: 'uploadEventImage', file: File): void;
  };

  const { t } = useI18n();
  const venue_id = defineModel('venue_id', { required: true, type: [String, null], default: null });
  const name = defineModel('name', { required: true, type: String });
  const description = defineModel('description', { required: false, type: String });
  const postSlot = defineModel('postSlot', { required: true, type: String });
  type PostSlot = { id: number; name: string }; // adapt if your API differs
  const postSlots = ref<PostSlot[]>([]);
  const loadingSlots = ref(false);

  const { errors = {} } = defineProps<{
    errors: any;
    eventImage?: string | null;
  }>();
  const emit = defineEmits<EmitsType>();

  const uploadEventImage = (file: File) => {
    emit('uploadEventImage', file);
  };

  const fetchPostSlots = async () => {
    loadingSlots.value = true;
    try {
      const { data } = await axios.get('taxonomies/post_slots');
      // assuming { data: { data: [{id, name}, ...] } } shape; adjust if needed
      postSlots.value = data?.data ?? data ?? [];
    } catch (e) {
      console.error('Error fetching post slots:', e);
      postSlots.value = [];
    } finally {
      loadingSlots.value = false;
    }
  };

  onMounted(fetchPostSlots);
</script>
<template>
  <div class="form-group form-input form-group--inline">
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <label class="form-group__label" for="avatar">{{ t('posts.image') }}</label>
    </div>
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <user-form-avatar :src="eventImage ?? ''" @change="uploadEventImage" is-outline />
    </div>
  </div>
  <form-input v-model="name" name="name" :label="t('posts.name.label')" is-inline />
  <form-input v-model="description" name="description" :label="t('posts.desc.label')" is-inline />
  <div class="form-group form-input form-group--inline">
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <label class="form-group__label" for="post_slot">{{ t('posts.post_slot.label') }}</label>
    </div>
    <div class="form-group__column form-group__column--right form-group__column--inline">
      <select
        id="post_slot"
        name="post_slot"
        v-model="postSlot"
        :disabled="loadingSlots || !postSlots.length"
        class="form-control"
      >
        <option value="" disabled>{{ loadingSlots ? t('common.loading') : t('common.select_option') }}</option>
        <option v-for="slot in postSlots" :key="slot.id" :value="slot.name">
          {{ slot.name }}
        </option>
      </select>
      <!-- optional error slot -->
      <div v-if="errors?.post_slot" class="invalid-feedback d-block">
        {{ errors.post_slot }}
      </div>
    </div>
  </div>
</template>
