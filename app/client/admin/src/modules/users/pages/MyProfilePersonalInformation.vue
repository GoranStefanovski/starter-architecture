<script setup lang="ts">
  import { IconSave } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { UserFormBasicInfo, UserFormContactInfo } from '../components';
  import { useMyProfile } from '../composables';
  import type { UserMyProfileForm } from '../types';
  import { PortletComponent, PortletBody, PortletHead, PortletHeadLabel, DashButton } from '@starter-core/dash-ui/src';
  import { USER_PERMISSIONS } from '@/modules/users/constants';
  import { useUserCheck } from '@/modules/users/composables';

  const { t } = useI18n();
  const { isLoading, data: formData, updateUser, uploadAvatar } = useMyProfile();
  const { checkUser } = useUserCheck();

  const validationSchema = {
    last_name(value: string) {
      if (value?.length >= 5) return true;
      return 'Name needs to be at least 5 characters.';
    },
  };

  const { handleSubmit, errors, setValues, defineField } = useForm<UserMyProfileForm>({
    validationSchema,
  });

  const submitHandler = handleSubmit((values) => {
    updateUser(values);
  });

  const uploadAvatarHandler = (file: File) => {
    uploadAvatar(file);
  };

  watch(() => {
    if (formData.value) {
      setValues({
        email: formData.value.email,
        first_name: formData.value.first_name,
        last_name: formData.value.last_name,
        phone_number: formData.value.phone_number,
        username: formData.value.username,
        artist_tag: formData.value.artist_tag,
        bio: formData.value.bio,
        city_from: formData.value.city_from,
        country_from: formData.value.country_from,
        instagram_link: formData.value.instagram_link,
        instagram_video: formData.value.instagram_video,
        facebook_link: formData.value.facebook_link,
        facebook_video: formData.value.facebook_video,
        soundcloud_link: formData.value.soundcloud_link,
        soundcloud_track: formData.value.soundcloud_track,
        spotify_link: formData.value.spotify_link,
        spotify_track: formData.value.spotify_track,
        youtube_link: formData.value.youtube_link,
        youtube_video: formData.value.youtube_video,
        contact_phone: formData.value.contact_phone,
        contact_email: formData.value.contact_email,
      });
    }
  }, [formData]);

  const [lastName] = defineField('last_name');
  const [firstName] = defineField('first_name');
  const [email] = defineField('email');
  const [phoneNumber] = defineField('phone_number');
  const [username] = defineField('username');
  const [artistTag] = defineField('artist_tag');
  const [bio] = defineField('bio');
  const [cityFrom] = defineField('city_from');
  const [countryFrom] = defineField('country_from');
  const [instagramLink] = defineField('instagram_link');
  const [instagramVideo] = defineField('instagram_video');
  const [facebookLink] = defineField('facebook_link');
  const [facebookVideo] = defineField('facebook_video');
  const [soundcloudLink] = defineField('soundcloud_link');
  const [soundcloudTrack] = defineField('soundcloud_track');
  const [spotifyLink] = defineField('spotify_link');
  const [spotifyTrack] = defineField('spotify_track');
  const [youtubeLink] = defineField('youtube_link');
  const [youtubeVideo] = defineField('youtube_video');
  const [contactPhone] = defineField('contact_phone');
  const [contactEmail] = defineField('contact_email');
</script>

<template>
  <PortletComponent>
    <PortletHead>
      <PortletHeadLabel>
        {{ t('users.personal-information.label') }}
      </PortletHeadLabel>
    </PortletHead>
    <PortletBody size="large">
      <form autocomplete="off" enctype="multipart/form-data" @submit.prevent="submitHandler">
        <UserFormBasicInfo
          v-model:lastName="lastName"
          v-model:email="email"
          v-model:firstName="firstName"
          v-model:phoneNumber="phoneNumber"
          v-model:username="username"
          :avatar="formData?.avatar_thumbnail"
          @upload-avatar="uploadAvatarHandler"
          :errors="errors"
          :hasEmailPermissions="checkUser('permissions', USER_PERMISSIONS.deleteVenues)"
        />
        <UserFormContactInfo
          v-if="checkUser('permissions', USER_PERMISSIONS.writeContactInfo)"
          v-model:artistTag="artistTag"
          v-model:bio="bio"
          v-model:cityFrom="cityFrom"
          v-model:countryFrom="countryFrom"
          v-model:instagramLink="instagramLink"
          v-model:instagramVideo="instagramVideo"
          v-model:facebookLink="facebookLink"
          v-model:facebookVideo="facebookVideo"
          v-model:soundcloudLink="soundcloudLink"
          v-model:soundcloudTrack="soundcloudTrack"
          v-model:spotifyLink="spotifyLink"
          v-model:spotifyTrack="spotifyTrack"
          v-model:youtubeLink="youtubeLink"
          v-model:youtubeVideo="youtubeVideo"
          v-model:contactPhone="contactPhone"
          v-model:contactEmail="contactEmail"
        />
        <DashButton type="submit" :icon="IconSave" :loading="isLoading" @click="submitHandler">
          {{ t('buttons.save') }}
        </DashButton>
        <!--    <unsaved-changes-modal-->
        <!--      v-if="confirmUnsavedChangesModal"-->
        <!--      @confirm-unsaved-changes="confirmUnsavedChanges"-->
        <!--      @cancel-unsaved-changes="cancelUnsavedChanges"-->
        <!--    />-->
      </form>
    </PortletBody>
  </PortletComponent>
</template>
