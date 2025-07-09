<script lang="ts" setup>
  import { useI18n } from 'vue-i18n';
  import VenueFormGalleryImage from '../VenueFormGalleryImage.vue';
  import type { VenueImage } from '@/modules/venues/types';

  type EmitsType = {
    (event: 'uploadVenueImage', file: File, image_type: string): void;
    (event: 'deleteVenueImage', imgId: number): void;
  };

  const { t } = useI18n();

  const { errors = {}, avatar } = defineProps<{
    errors: any;
    avatar?: string | null;
    venueTypes: any[];
    venueImages?: VenueImage[];
  }>();
  const emit = defineEmits<EmitsType>();
</script>
<template>
  <div class="form-group form-input form-group--inline form-group--gallery-image">
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <venue-form-gallery-image
        v-for="image in venueImages"
        :key="image.id"
        :img-id="image.id"
        :src="image.thumbnail.srcset"
        @change="(file) => emit('uploadVenueImage', file, 'venue_image')"
        @delete="(imgId) => emit('deleteVenueImage', imgId)"
      />
    </div>
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <venue-form-gallery-image :src="null" :img-id="null" @change="(file) => emit('uploadVenueImage', file, 'venue_image')" />
    </div>
  </div>
</template>
