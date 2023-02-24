<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiBallotOutline"
        :title="route.meta.title"
        main
      >
      </SectionTitleLineWithButton>

      <PageLoader v-if="loading"/>

      <template v-else>
        <CardBox is-form @submit.prevent="submit">
          <FormField label="User Name & Email">
            <FormControl
              v-model="form.name"
              :icon="mdiAccount"
              placeholder="User Name"
              disabled
            />
            <FormControl
              v-model="form.email"
              type="email"
              :icon="mdiAt"
              placeholder="User Email"
              disabled
            />
          </FormField>

          <FormField
            label="Email Verified At"
            help="Email Verification"
          >
            <FormControl
              v-model="form.email_verified_at"
              :icon="mdiEmailCheck"
              placeholder="Email Verified At"
              disabled
            />
          </FormField>

          <FormField label="Account Created At & Updated At">
            <FormControl
              v-model="form.created_at"
              :icon="mdiCalendarRange"
              placeholder="Created At"
              disabled
            />
            <FormControl
              v-model="form.updated_at"
              :icon="mdiCalendarRange"
              placeholder="Updated At"
              disabled
            />
          </FormField>

          <FormField label="Administrative Rights">
            <FormCheckRadioGroup
              v-model="form.is_admin"
              name="sample-switch"
              type="switch"
              :options="{ is_admin: 'Is Admin' }"
            />
            <template v-if="form.is_admin">
              <BaseButtons>
                <BaseButton
                  :to="{
                    name: 'app.users.view',
                    params: {
                      id: form.authorized_by ?? authStore.user.data.id
                    }
                  }"
                  :icon="mdiShieldAccount"
                  label="Authorized By"
                  color="contrast"
                  rounded-full
                  small
                />
              </BaseButtons>
            </template>
          </FormField>

          <FormField label="Customer Account">
            <FormCheckRadioGroup
              v-model="form.is_customer"
              name="sample-switch"
              type="switch"
              :options="{ is_customer: 'Is Customer' }"
              disabled
            />
          </FormField>

          <BaseDivider />

          <template v-if="form.is_customer">
            <FormField label="Customer Name">
              <FormControl
                v-model="form.customer.first_name"
                :icon="mdiAccount"
                placeholder="Customer Name"
                disabled
              />
              <FormControl
                v-model="form.customer.last_name"
                :icon="mdiAccount"
                placeholder="Customer Name"
                disabled
              />
            </FormField>

            <FormField label="Customer Email & Phone">
              <FormControl
                v-model="form.customer.email"
                type="email"
                :icon="mdiAt"
                placeholder="Customer Email"
                disabled
              />
              <FormControl
                v-model="form.customer.phone"
                :icon="mdiAccount"
                placeholder="Customer Phone"
                disabled
              />
            </FormField>

            <FormField label="Status" >
              <FormCheckRadioGroup
                v-model="form.customer.status"
                name="sample-switch"
                type="switch"
                :options="{ status: 'Status' }"
                disabled
              />
            </FormField>

            <FormField label="Access" :class="[form.customer.created_by !== form.id] ? 'hidden' : ''">
              <BaseButtons>
                <template v-if="form.customer.created_by !== form.id">
                  <BaseButton
                      :to="{ name: 'app.users.view', params: { id: form.customer.created_by } }"
                      :icon="mdiAccountCheck"
                      label="Created By"
                      color="contrast"
                      rounded-full
                      small
                    />
                </template>
                <template v-if="form.customer.created_by !== form.customer.updated_by">
                  <BaseButton
                    :to="{ name: 'app.users.view', params: { id: form.customer.updated_by } }"
                    :icon="mdiShieldAccount"
                    label="Updated By"
                    color="contrast"
                    rounded-full
                    small
                  />
                </template>
              </BaseButtons>
            </FormField>

            <FormField label="Customer Account Created At & Updated At">
              <FormControl
                v-model="form.customer.created_at"
                :icon="mdiCalendarRange"
                placeholder="Created At"
                disabled
              />
              <FormControl
                v-model="form.customer.updated_at"
                :icon="mdiCalendarRange"
                placeholder="Updated At"
                disabled
              />
            </FormField>

            <FormField label="Customer Address"
              help="Address 1 & Address 2"
            >
              <FormControl
                v-model="form.customer.address.address1"
                :icon="mdiMapMarker"
                placeholder="Address 1"
                disabled
              />
              <FormControl
                v-model="form.customer.address.address2"
                :icon="mdiMapMarker"
                placeholder="Address 2"
                disabled
              />
            </FormField>

            <FormField help="City & Zip Code">
              <FormControl
                v-model="form.customer.address.city"
                :icon="mdiCityVariant"
                placeholder="City"
                disabled
              />
              <FormControl
                v-model="form.customer.address.zip_code"
                :icon="mdiOfficeBuildingMarker"
                placeholder="Zip Code"
                disabled
              />
            </FormField>

            <FormField help="Country Code & State">
              <FormControl
                v-model="form.customer.address.country_code"
                :icon="mdiFlag"
                placeholder="Country Code"
                disabled
              />
              <FormControl
                v-model="form.customer.address.state"
                :icon="mdiFlagCheckered"
                placeholder="State"
                disabled
              />
            </FormField>

            <FormField label="Customer Address Updated At">
              <FormControl
                v-model="form.customer.address.updated_at"
                :icon="mdiCalendarRange"
                placeholder="Updated At"
                disabled
              />
            </FormField>

          </template>

          <BaseDivider />

          <template #footer>
            <BaseButtons>
              <BaseButton type="submit" color="info" label="Submit" />
              <BaseButton
                @click="resetForm"
                color="info"
                outline
                label="Reset"
              />
            </BaseButtons>
          </template>
        </CardBox>
      </template>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import { computed, reactive, ref, watch } from "vue";
import {
  mdiBallotOutline,
  mdiAccount,
  mdiAt,
  mdiEmailCheck,
  mdiCalendarRange,
  mdiShieldAccount,
  mdiPlus,
  mdiAccountCheck,
  mdiMapMarker,
  mdiCityVariant,
  mdiOfficeBuildingMarker,
  mdiFlag,
  mdiFlagCheckered,
 } from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import CardBoxModal from "@/components/CardBoxModal.vue";
import FormCheckRadioGroup from "@/components/FormCheckRadioGroup.vue";
import FormFilePicker from "@/components/FormFilePicker.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import ButtonLoading from "@/components/custom/ButtonLoading.vue";
import PageLoader from "@/components/custom/PageLoader.vue";
import { useRoute, useRouter } from "vue-router";
import { useUserStore } from "@/stores/user";
import { useAuthStore } from "@/stores/auth";
import { useStore } from "@/stores/store";
import { useFileReaderImage } from "@/helpers/fileReaderImage";

const route = useRoute();

const router = useRouter();

const userStore = useUserStore();

const authStore = useAuthStore();

const loading = computed(() => userStore.currentUser.loading);

const initialState = {
  id: null,
  name: null,
  email: null,
  email_verified_at: null,
  created_at: null,
  updated_at: false,
  is_admin: false,
  authorized_by: null,
  is_customer: false,
  customer: {
    id: null,
    first_name: null,
    last_name: null,
    email: null,
    phone: null,
    status: null,
    created_by: null,
    updated_by: null,
    created_at: null,
    updated_at: null,
    address: {
      id: null,
      address1: null,
      address2: null,
      city: null,
      state: null,
      zip_code: null,
      country_code: null,
      customer_id: null,
      created_at: null,
      updated_at: null,
    },
  },
};

const form = reactive({ ...initialState });

const resetForm = () => {
  Object.assign(form, initialState);
  checkPage();
};

watch(route, (newVal, oldVal) => {
  if (!newVal.params.id) {
    resetForm();
  } else if (newVal === oldVal) {
    resetForm();
  }
});

const checkPage = () => {
  if (route.params.id) {
    (async () => {
      try {
        return await userStore.getUser(route.params.id);
      } catch (error) {
        return router.push({ name: "app.users" });
      }
    })();
  }
};

(() => {
  checkPage();
})();

watch(
  () => userStore.currentUser.data,
  (newVal, oldVal) => {
    Object.assign(form, JSON.parse(JSON.stringify(newVal)));
  }
);

const [imageReaderState, imageReaderOnChoose, imageReaderConfirmation] =
  useFileReaderImage();

watch(imageReaderState, (newVal, oldVal) => {
  form.image = newVal.image;
  form.image_url = newVal.image;

  if (newVal.denied) {
    checkPage();
  }
});

const submit = async () => {
  try {
    const { data } = await userStore.saveUser(form);
    router.push({
      name: "app.users.view",
      params: { id: data.id },
    });
    useStore().notify({
      type: "success",
      message: "User was successfully saved.",
    });
    return data;
  } catch ({ response }) {
    useStore().notify({
      type: "error",
      message: response.data.message,
    });
    return response;
  }
};

const formStatusWithHeader = ref(true);

const formStatusCurrent = ref(0);

const formStatusOptions = ["info", "success", "danger", "warning"];

const formStatusSubmit = () => {
  formStatusCurrent.value = formStatusOptions[formStatusCurrent.value + 1]
    ? formStatusCurrent.value + 1
    : 0;
};
</script>
