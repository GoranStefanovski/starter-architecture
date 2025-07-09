<script lang="ts" setup>
  import VueDatePicker from '@vuepic/vue-datepicker';
  import { ref, watch, onMounted, computed } from 'vue';
  import { useI18n } from 'vue-i18n';
  import type { TicketFormItem } from '../../types/form.ts';
  import UserFormAvatar from '@/modules/events/components/UserFormAvatar.vue';
  import TicketForm from '@/modules/events/components/forms/TicketForm.vue';
  import { EVENT_API_ENDPOINTS } from '@/modules/events/constants';
  import { loadGoogleMaps } from '@/plugins/googleMaps';
  import { FormDropdown, FormInput, FormMultiSelect } from '@starter-core/dash-ui/src';
  import '@vuepic/vue-datepicker/dist/main.css';
  import axios from 'axios';
  import './EventFormBasicInfo.scss';

  type EmitsType = {
    (event: 'uploadEventImage', file: File): void;
  };

  const { t } = useI18n();
  const venue_id = defineModel('venue_id', { required: true, type: [String, null], default: null });
  const name = defineModel('name', { required: true, type: String });
  const description = defineModel('description', { required: false, type: String });
  const country = defineModel('country', { required: true, type: String });
  const city = defineModel('city', { required: true, type: String });
  const address = defineModel('address', { required: true, type: String });
  const lng = defineModel('lng', { required: true, type: Number });
  const lat = defineModel('lat', { required: true, type: Number });
  const event_start = defineModel('event_start', { required: true, type: Date });
  const event_end = defineModel('event_end', { required: true, type: Date });
  const tickets = defineModel('tickets', { required: true, type: Array<any>, default: () => [] });
  const genreIds = defineModel('genreIds', { required: true, type: Array<Number>, default: () => [] });

  const availableVenues = ref<any[]>([]);
  const isVenue = ref(false);
  const mapContainer = ref<HTMLElement | null>(null);
  const cityInput = ref<HTMLElement | null>(null);
  let map: any = null;
  let marker: any = null;
  let autocomplete: any;
  let sessionToken: any;
  const allowedCountries = [{ id: 'mk', name: 'North Macedonia' }];
  let isUserDragging = false;

  const createEmptyTicket = (): TicketFormItem => {
    const freeEntryType = ticketTypes?.find((t) => t.id === 'free_entry');

    return {
      event_id: 0,
      price: 0,
      quantity: 0,
      sale_start: new Date(),
      sale_end: new Date(),
      type: freeEntryType ? freeEntryType.id : 'free_entry',
    };
  };

  const {
    errors = {},
    musicGenres,
    ticketTypes,
  } = defineProps<{
    errors: any;
    eventImage?: string | null;
    musicGenres: any[];
    ticketTypes: any[];
  }>();
  const emit = defineEmits<EmitsType>();

  const uploadEventImage = (file: File) => {
    emit('uploadEventImage', file);
  };

  const availableTicketTypes = computed(() => {
    return ticketTypes.map((type) => {
      const isUsed = tickets.value.some((ticket) => ticket.type === type.id);

      return {
        id: type.id,
        name: type.name,
        isDisabled: isUsed,
      };
    });
  });

  const adjustedTicketTypes = (currentType: string) => {
    return availableTicketTypes.value.map((type) => ({
      ...type,
      isDisabled: type.id !== currentType && type.isDisabled,
    }));
  };

  const selectedVenue = computed((): any => {
    console.log('asdasdasdasdadasda');
    return availableVenues.value.find((v) => v.id === venue_id.value);
  });

  watch(selectedVenue, (venue) => {
    if (venue) {
      lat.value = venue.lat;
      lng.value = venue.lng;
      address.value = venue.address;
      city.value = venue.city;
      country.value = venue.country;
    }
  });

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

  //TODO: should be put in a seperate component, having trouble doing so, map not rendering
  //TODO: change AutoComplete to PlacesAutoComplete & Marker to AdvancedMarkerElement in future (working fine for now)
  onMounted(async () => {
    if (!tickets.value.length) {
      const updated = [...tickets.value];
      updated.push(createEmptyTicket());
      tickets.value = updated;
    }
    if (!country.value) {
      country.value = 'mk';
      city.value = 'Bitola';
      lat.value = 41.0312;
      lng.value = 21.3339;
    }
    try {
      const fallbackCity = city.value ?? 'Bitola';
      const { data } = await axios.get(EVENT_API_ENDPOINTS.getVenueFromCity(fallbackCity));
      availableVenues.value = data;
    } catch (error) {
      availableVenues.value = [];
    }
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

    autocomplete.addListener('place_changed', async () => {
      const place = autocomplete.getPlace();
      if (!place.geometry) return;

      const loc = place.geometry.location;
      city.value = place.name;
      lat.value = loc.lat();
      lng.value = loc.lng();

      isUserDragging = false;
      map.setCenter(loc);
      marker.setPosition(loc);

      try {
        const { data } = await axios.get(EVENT_API_ENDPOINTS.getVenueFromCity(place.name));
        availableVenues.value = data;
      } catch (error) {
        console.error('Failed to fetch venues', error);
        availableVenues.value = [];
      }
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

  watch(isVenue, (val) => {
    if (val) {
      country.value = '';
      city.value = '';
      address.value = '';
      lat.value = 0;
      lng.value = 0;
    } else {
      venue_id.value = '';
    }
  });
</script>
<template>
  <div class="form-group form-input form-group--inline">
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <label class="form-group__label" for="avatar">{{ t('events.image') }}</label>
    </div>
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <user-form-avatar :src="eventImage ?? ''" @change="uploadEventImage" is-outline />
    </div>
  </div>
  <form-input v-model="name" name="name" :label="t('events.name.label')" is-inline />
  <form-input v-model="description" name="description" :label="t('events.desc.label')" is-inline />
  <form-multi-select
    v-model="genreIds"
    id="music_genres_id"
    :options="musicGenres"
    label="Music Genres"
    :errors="[errors?.music_genres_id]"
    is-inline
  />
  <label class="datepicker-label" for="event_start">
    {{ t('events.event_time.start') }}
  </label>
  <VueDatePicker
    :name="t('events.event_time.start')"
    v-model="event_start"
    :min-date="new Date()"
    :placeholder="'Choose start date'"
  />
  <label class="datepicker-label" for="event_end">
    {{ t('events.event_time.end') }}
  </label>
  <VueDatePicker :name="t('events.event_time.end')" v-model="event_end" :min-date="new Date()" :placeholder="'Choose end date'" />
  <TicketForm v-for="(ticket, i) in tickets" :key="i" :ticket="ticket" :ticket-types="adjustedTicketTypes(ticket.type)" />
  <hr />
  <div class="form-group form-input form-group--inline">
    <div class="event_venue-mode">
      <label> <input type="radio" v-model="isVenue" :value="true" /> {{ t('events.select_venue') }} </label>
      <label style="margin-left: 1rem">
        <input type="radio" v-model="isVenue" :value="false" /> {{ t('events.manual_address') }}
      </label>
    </div>
    <label class="form-group__label">| {{ isVenue ? t('events.venue_mode') : t('events.address_mode') }}</label>
  </div>
  <form-dropdown
    v-if="isVenue"
    id="venue_id"
    v-model="venue_id"
    name="venue_id"
    :label="t('events.venue.label')"
    :options="availableVenues"
    is-inline
  />
  <div v-else>
    <form-dropdown
      id="country"
      v-model="country"
      name="country"
      :label="t('events.address.country')"
      :options="allowedCountries"
      is-inline
    />
    <form-input ref="cityInput" v-model="city" name="city" :label="t('events.address.city')" is-inline />
    <form-input v-model="address" name="address" :label="t('events.address.label')" is-inline />
    <form-input v-model="lat" type="number" name="lat" :label="t('events.address.lat')" is-inline />
    <form-input v-model="lng" type="number" name="lng" :label="t('events.address.lng')" is-inline />
  </div>
  <div v-show="!isVenue" ref="mapContainer" style="width: 100%; height: 400px; margin-top: 1rem" />
</template>
