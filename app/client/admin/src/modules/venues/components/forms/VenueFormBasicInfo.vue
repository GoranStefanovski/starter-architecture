<script lang="ts" setup>
  import { IconMail } from '@starter-core/icons';
  import { ref, watch, onMounted } from 'vue';
  import { useI18n } from 'vue-i18n';
  import UserFormAvatar from '../UserFormAvatar.vue';
  import { FormDropdown, FormInput } from '@starter-core/dash-ui/src';
  import { loadGoogleMaps } from '@/plugins/googleMaps';

  type EmitsType = {
    (event: 'uploadAvatar', file: File): void;
  };

  const { t } = useI18n();
  const name = defineModel('name', { required: true, type: String });
  const venueTypeId = defineModel('venue_type_id', { required: true, type: Number });
  const bio = defineModel('bio', { required: false, type: String });
  const address = defineModel('address', { required: true, type: String });
  const lat = defineModel('lat', { required: true, type: Number });
  const lng = defineModel('lng', { required: true, type: Number });
  const email = defineModel('email', { required: true, type: String });
  const phone_number = defineModel('phone_number', { required: true, type: String });
  const city = defineModel('city', { required: true, type: String });
  const country = defineModel('country', { required: true, type: String });
  const countryCodeMap = {
    'North Macedonia': 'mk',
    Germany: 'de',
    France: 'fr',
    USA: 'us',
  };

  const mapContainer = ref<HTMLElement | null>(null);
  const cityInput = ref<HTMLElement | null>(null);
  let map: any = null;
  let marker: any = null;
  let autocomplete: any;
  let sessionToken: any;
  const allowedCountries = [
    { id: 'mk', name: 'North Macedonia' },
    { id: 'de', name: 'Germany' },
    { id: 'fr', name: 'France' },
    { id: 'us', name: 'USA' },
  ];
  let isUserDragging = false;

  const { errors = {}, avatar } = defineProps<{
    errors: any;
    avatar?: string | null;
    venueTypes: any[];
  }>();
  const emit = defineEmits<EmitsType>();

  const uploadAvatar = (file: File) => {
    emit('uploadAvatar', file);
  };

  //TODO: should be put in a seperate component
  //TODO: change AutoComplete to PlacesAutoComplete & Marker to AdvancedMarkerElement in future (working fine for now)

  watch(country, (newCode) => {
    if (autocomplete && newCode) {
      autocomplete.setComponentRestrictions({ country: newCode });
    }
  });

  watch([lat, lng], ([newLat, newLng]) => {
    if (!isUserDragging && map && marker) {
      const pos = { lat: newLat, lng: newLng };
      map.setCenter(pos);
      marker.setPosition(pos);
    }
  });

  onMounted(async () => {
    const maps = await loadGoogleMaps();
    const center = { lat: lat.value || 41.0312, lng: lng.value || 21.3339 };

    const inputEl = (cityInput.value as any)?.$el?.querySelector('input');
    if (!inputEl) return;

    sessionToken = new maps.places.AutocompleteSessionToken();
    autocomplete = new maps.places.Autocomplete(inputEl, {
      types: ['(cities)'],
      componentRestrictions: { country: (country.value || 'mk').toLowerCase() },
      sessionToken,
    });

    map = new maps.Map(mapContainer.value!, {
      center,
      zoom: 14,
    });

    marker = new maps.Marker({
      position: center,
      map,
      draggable: true,
    });

    inputEl.addEventListener('input', () => {
      sessionToken = new maps.places.AutocompleteSessionToken();
      autocomplete.setOptions({ sessionToken });
    });

    autocomplete.addListener('place_changed', () => {
      const place = autocomplete.getPlace();
      if (!place.geometry) return;

      const loc = place.geometry.location;
      city.value = place.name;
      lat.value = loc.lat();
      lng.value = loc.lng();

      isUserDragging = false;
      map.setCenter(loc);
      marker.setPosition(loc);
    });

    marker.addListener('dragstart', () => {
      isUserDragging = true;
    });

    marker.addListener('dragend', () => {
      const pos = marker.getPosition();
      if (pos) {
        lat.value = pos.lat();
        lng.value = pos.lng();
      }
    });
  });
</script>
<template>
  <div class="form-group form-input form-group--inline">
    <!-- <div class="form-group__column form-group__column--left form-group__column--inline">
      <label class="form-group__label" for="avatar">{{ t('users.avatar') }}</label>
    </div>
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <user-form-avatar :src="avatar" @change="uploadAvatar" is-circle is-outline />
    </div> -->
  </div>
  <form-input v-model="name" name="name" :label="t('venues.name.label')" is-inline />
  <form-dropdown
    v-model="venueTypeId"
    id="venue_type_id"
    :options="venueTypes"
    label="Venue Type"
    :errors="[errors?.venue_type_id]"
  />
  <form-input v-model="bio" name="bio" :label="t('venues.bio.label')" is-inline />
  <form-input v-model="address" name="address" :label="t('venues.address.label')" is-inline />
  <form-input v-model="email" name="email" :label="t('venues.contact.email')" is-inline />
  <form-input v-model="phone_number" name="phone_number" :label="t('venues.contact.phone_number')" is-inline />
  <form-dropdown id="country" v-model="country" name="country" :label="t('venues.address.country')" :options="allowedCountries" />
  <form-input ref="cityInput" v-model="city" name="city" :label="t('venues.address.city')" is-inline />
  <form-input v-model="lat" type="number" name="lat" :label="t('venues.address.lat')" is-inline />
  <form-input v-model="lng" type="number" name="lng" :label="t('venues.address.lng')" is-inline />
  <div ref="mapContainer" style="width: 100%; height: 400px; margin-top: 1rem" />
</template>
