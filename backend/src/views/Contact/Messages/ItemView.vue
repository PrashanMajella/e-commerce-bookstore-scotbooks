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

          <SectionTitle first>Contact Information</SectionTitle>
          <FormField label="First & Last Name">
            <FormControl
              v-model="form.first_name"
              :icon="mdiAccount"
              placeholder="First Name"
              disabled
            />
            <FormControl
              v-model="form.last_name"
              :icon="mdiAccount"
              placeholder="Last Name"
              disabled
            />
          </FormField>

          <FormField label="Phone & Email">
            <FormControl
              v-model="form.phone"
              :icon="mdiPhone"
              placeholder="Phone"
              disabled
            />
            <FormControl
              v-model="form.email"
              type="email"
              :icon="mdiAt"
              placeholder="Email"
              disabled
            />
          </FormField>

          <FormField label="Subject">
            <FormControl
              v-model="form.subject"
              :icon="mdiMapMarker"
              placeholder="Address 1"
              disabled
            />
          </FormField>

          <FormField
            label="Message"
            help="Contact Message"
          >
            <FormControl
              v-model="form.message"
              type="textarea"
              placeholder="Explain how we can help you"
              disabled
            />
          </FormField>

          <BaseDivider />

          <FormField label="Seen">
            <FormCheckRadioGroup
              v-model="form.seen"
              name="sample-switch"
              type="switch"
              :options="{ seen: 'Seen' }"
            />
          </FormField>

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
  mdiMapMarker,
  mdiAccount,
  mdiPhone,
  mdiAt,
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
import { useContactMessageStore } from "@/stores/contactMessage";
import { useStore } from "@/stores/store";
import { useFileReaderImage } from "@/helpers/fileReaderImage";

const route = useRoute();

const router = useRouter();

const contactMessageStore = useContactMessageStore();

const loading = computed(() => contactMessageStore.currentContactMessage.loading);

const initialState = {
  id: null,
  first_name: null,
  last_name: null,
  email: null,
  phone: null,
  subject: null,
  message: null,
  seen: false,
  created_at: null,
  updated_at: null
};

const form = reactive({ ...initialState });

const resetForm = () => {
  Object.assign(form, initialState);
  checkPage();
};

watch(route, (newVal, oldVal) => {
  if (!newVal.params.id) {
    resetForm();
  }
});

const checkPage = () => {
  if (route.params.id) {
    (async () => {
      try {
        return await contactMessageStore.getContactMessage(route.params.id);
      } catch (error) {
        return router.push({ name: "app.contact.messages" });
      }
    })();
  }
};

(() => {
  checkPage();
})();

watch(
  () => contactMessageStore.currentContactMessage.data,
  (newVal, oldVal) => {
    Object.assign(form, JSON.parse(JSON.stringify(newVal)));
  }
);

const submit = async () => {
  try {
    const { data } = await contactMessageStore.saveContactMessage(form);
    router.push({
      name: "app.contact.messages.view",
      params: { id: data.id },
    });
    useStore().notify({
      type: "success",
      message: "ContactMessage was successfully saved.",
    });
    return data;
  } catch (error) {
    useStore().notify({
      type: "error",
      message: error.message,
    });
    return error;
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
