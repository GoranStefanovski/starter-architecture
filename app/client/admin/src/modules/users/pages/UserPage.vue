<script lang="ts" setup>
  import { IconSave, IconArrowleft } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch, computed } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { useRoute } from 'vue-router';
  import { UserFormPasswordTab, UserFormBasicInfo, UserFormContactInfo } from '../components';
  import { useUsersForm } from '../composables';
  import type { UserFormItem } from '../types';
  import { TabbedContent, TabbedContentTab, PageWrapper, PAGE_WRAPPER_SLOTS, SubheaderTitle, SkSection } from '@/components';
  import UserRolesDropdown from '@/modules/users/components/UserRolesDropdown.vue';
  import { DashButton, DashLink, FormSwitch } from '@starter-core/dash-ui/src';

  const { t } = useI18n();
  const personalInformationLabel = t('users.personal-information.label');
  const changePasswordLabel = t('users.password.change');
  const contactInformationLabel = t('users.contact-information.label');
  const route = useRoute();
  const isEditPage = computed(() => route.name == 'edit.user');
  const userId = Number(route.params.userId);

  const validationSchema = {
    last_name(value: string) {
      if (value?.length >= 5) return true;
      return 'Name needs to be at least 5 characters.';
    },
  };

  const { isLoading, data: formData, createUser, updateUser, uploadAvatar } = useUsersForm(userId);

  const { handleSubmit, errors, setValues, defineField } = useForm<UserFormItem>({
    validationSchema,
  });

  const submitHandler = handleSubmit((values) => {
    if (isEditPage.value) {
      updateUser(values);
    } else {
      createUser(values);
    }
  });

  const uploadAvatarHandler = (file: File) => {
    uploadAvatar(file);
  };

  watch(() => {
    if (formData.value) {
      setValues({
        id: formData.value.id,
        email: formData.value.email,
        first_name: formData.value.first_name,
        last_name: formData.value.last_name,
        phone_number: formData.value.phone_number,
        role: formData.value.role,
        is_disabled: formData.value.is_disabled,
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
  const [phoneNumber] = defineField('phone_number');
  const [email] = defineField('email');
  const [isDisabled] = defineField('is_disabled');
  const [role] = defineField('role');
  const [password] = defineField('password');
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
  <PageWrapper size="large" justify-content="center">
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle title="Edit user" :description="`${firstName} ${lastName}`" />
    </template>
    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/users" :icon="IconArrowleft" theme="clean">
        {{ t('buttons.back') }}
      </DashLink>
      <DashButton type="submit" :icon="IconSave" :loading="isLoading" @click="submitHandler">
        {{ t('buttons.save') }}
      </DashButton>
    </template>
    <form autocomplete="off" enctype="multipart/form-data" @submit.prevent="submitHandler">
      <TabbedContent :isLoading="isLoading">
        <TabbedContentTab :label="personalInformationLabel" id="basic-info">
          <SkSection :title="t('users.user_status')">
            <user-roles-dropdown v-model:role="role" />
            <form-switch
              v-model="isDisabled"
              id="enabled"
              theme="danger"
              type="outline"
              :label="t('users.status.label')"
              :helper-text="`User is  ${isDisabled ? 'disabled' : 'enabled'}`"
            />
          </SkSection>
          <SkSection title="Customer Info">
            <UserFormBasicInfo
              v-model:lastName="lastName"
              v-model:email="email"
              v-model:firstName="firstName"
              v-model:phoneNumber="phoneNumber"
              v-model:username="username"
              :avatar="formData?.avatar_thumbnail"
              @upload-avatar="uploadAvatarHandler"
              :errors="errors"
            />
          </SkSection>
        </TabbedContentTab>
        <TabbedContentTab :label="changePasswordLabel" id="change-password">
          <UserFormPasswordTab v-model:password="password" />
        </TabbedContentTab>
        <TabbedContentTab :label="contactInformationLabel" id="contact-info">
          <UserFormContactInfo
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
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
