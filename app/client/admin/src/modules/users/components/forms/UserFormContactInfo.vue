<script lang="ts" setup>
  import { FormInput } from '@starter-core/dash-ui/src';

  const artistTag = defineModel('artistTag', { required: false, type: String });
  const bio = defineModel('bio', { required: false, type: String });
  const cityFrom = defineModel('cityFrom', { required: false, type: String });
  const countryFrom = defineModel('countryFrom', { required: false, type: String });
  const instagramLink = defineModel('instagramLink', { required: false, type: String });
  const facebookLink = defineModel('facebookLink', { required: false, type: String });
  const soundcloudLink = defineModel('soundcloudLink', { required: false, type: String });
  const soundcloudTrack = defineModel('soundcloudTrack', { required: false, type: String });
  const spotifyLink = defineModel('spotifyLink', { required: false, type: String });
  const spotifyTrack = defineModel('spotifyTrack', { required: false, type: String });
  const youtubeLink = defineModel('youtubeLink', { required: false, type: String });
  const youtubeVideo = defineModel('youtubeVideo', { required: false, type: String });
  const contactPhone = defineModel('contactPhone', { required: false, type: String });
  const contactEmail = defineModel('contactEmail', { required: false, type: String });
</script>
<template>
  <form-input v-model="contactPhone" name="contact-phone" label="Contact Phone" is-inline />
  <form-input v-model="contactEmail" name="contact-email" label="Contact Email" is-inline />
  <form-input v-model="artistTag" name="artist-tag" label="Artist Tag" is-inline />
  <form-input v-model="bio" name="bio" label="Biography" is-inline />
  <br />
  <form-input v-model="cityFrom" name="city-from" label="City From" is-inline />
  <form-input v-model="countryFrom" name="country-from" label="Country From" is-inline />
  <br />
  <form-input v-model="instagramLink" name="instagram-link" label="Instagram Link" is-inline />
  <br />
  <form-input v-model="facebookLink" name="facebook-link" label="Facebook Link" is-inline />
  <br />
  <form-input v-model="soundcloudLink" name="soundcloud-link" label="SoundCloud Link" is-inline />
  <form-input v-model="soundcloudTrack" name="soundcloud-track" label="SoundCloud Track URL" is-inline />
  <br />
  <form-input v-model="spotifyLink" name="spotify-link" label="Spotify Link" is-inline />
  <form-input v-model="spotifyTrack" name="spotify-track" label="Spotify Track URL" is-inline />
  <br />
  <form-input v-model="youtubeLink" name="youtube-link" label="YouTube Link" is-inline />
  <form-input v-model="youtubeVideo" name="youtube-video" label="YouTube Video URL" is-inline />
</template>
