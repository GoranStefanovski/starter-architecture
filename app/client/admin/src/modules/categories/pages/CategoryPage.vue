<script lang="ts" setup>
  import { IconSave, IconArrowleft } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch, computed, ref, onMounted } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { useRoute, useRouter } from 'vue-router';
  import { CategoryFormBasicInfo } from '../components';
  import { useCategoriesForm } from '../composables';
  import type { CategoryFormItem } from '../types';
  import { TabbedContent, TabbedContentTab, PageWrapper, PAGE_WRAPPER_SLOTS, SubheaderTitle, SkSection } from '@/components';
  import { DashButton, DashLink, FormSwitch } from '@starter-core/dash-ui/src';
  import axios from 'axios';
  import { useAuth } from '@websanova/vue-auth/src/v3.js';

  const { t } = useI18n();
  const router = useRouter();
  const route = useRoute();
  const isEditPage = computed(() => route.name === 'edit.category');
  const categoryId = Number(route.params.categoryId);

  // 🔥 Get current user info from API or auth store
  const auth = useAuth();
  const user = computed(() => auth.user);

  // 📝 Use form
  const { isLoading, data: formData, createCategory, updateCategory } = useCategoriesForm(categoryId);

  const { handleSubmit, errors, setValues, defineField } = useForm<CategoryFormItem>();

  const submitHandler = handleSubmit((values) => {
    if (isEditPage.value) {
      updateCategory(values);
    } else {
      createCategory(values);
    }
  });

  // 📝 Fields
  const [name] = defineField('name');
  const [slug] = defineField('slug');
  const [description] = defineField('description');
  const [isActive] = defineField('is_active');

  watch(() => {
    if (formData.value) {
      setValues({
        id: formData.value.id,
        name: formData.value.name,
        slug: formData.value.slug,
        description: formData.value.description,
        is_active: formData.value.is_active,
      });
    }
  }, [formData]);
</script>

<template>
  <PageWrapper size="large" justify-content="center">
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle :title="isEditPage ? 'Edit Category' : 'Add Category'" :description="`${name ? name : ''}`" />
    </template>

    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/categories" :icon="IconArrowleft" theme="clean">
        {{ t('buttons.back') }}
      </DashLink>
      <DashButton type="submit" :icon="IconSave" :loading="isLoading" @click="submitHandler">
        {{ t('buttons.save') }}
      </DashButton>
    </template>

    <form autocomplete="off" @submit.prevent="submitHandler">
      <TabbedContent :isLoading="isLoading">
        <TabbedContentTab :label="t('categories.basic_info')" id="basic-info">
          <SkSection :title="t('categories.category_status')">
            <form-switch
              v-model="isActive"
              id="enabled"
              theme="success"
              type="outline"
              :label="t('categories.status.label')"
              :helper-text="`Category is ${!isActive ? 'disabled' : 'enabled'}`"
            />
          </SkSection>
          <hr />
          <SkSection :title="t('categories.basic_info')">
            <CategoryFormBasicInfo
              v-model:description="description"
              v-model:name="name"
              v-model:slug="slug"
              :isEditPage="isEditPage"
              :errors="errors"
            />
          </SkSection>
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
