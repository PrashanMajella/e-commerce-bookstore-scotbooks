<template>
  <LayoutAuthenticated>
    <CardBoxModal
      v-if="form.image_url && !imageReaderState.loading"
      v-model="imageReaderState.isActive"
      title="Please confirm action"
      button-label="Confirm"
      has-cancel
      @confirmation="imageReaderConfirmation"
    >
      <div class="flex items-center justify-center">
        <img
          :src="form.image"
          alt="item-image"
          class="w-[225px] h-[360px] object-cover rounded-lg"
        />
      </div>
    </CardBoxModal>

    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiBallotOutline"
        :title="route.meta.title"
        main
      >
        <BaseButton
          :to="{ name: 'app.products.create' }"
          :icon="mdiPlus"
          label="Add new Item"
          color="contrast"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>

      <PageLoader v-if="loading"/>

      <template v-else>
        <CardBox is-form @submit.prevent="submit">
          <FormField label="Product Title & Price">
            <FormControl
              v-model="form.title"
              :icon="mdiCart"
              placeholder="Product Title"
            />
            <FormControl
              v-model="form.price"
              type="number"
              min="0.00"
              max="99999.99"
              step="0.01"
              :icon="mdiCurrencyUsd"
              placeholder="Set Price"
            />
          </FormField>

          <FormField
            label="Description"
            help="Product Description. Max 255 characters"
          >
            <FormControl
              type="textarea"
              placeholder="Explain how we can help you"
              v-model="form.description"
            />
          </FormField>

          <BaseDivider />

          <FormField label="Switch">
            <FormCheckRadioGroup
              v-model="form.published"
              name="sample-switch"
              type="switch"
              :options="{ published: 'Published' }"
            />
          </FormField>

          <BaseDivider />

          <div class="flex justify-center items-center">
            <img
              v-if="
                form.image_url &&
                !imageReaderState.isActive &&
                !imageReaderState.denied
              "
              :src="form.image_url"
              alt="item-image"
              class="w-[225px] h-[360px] object-cover rounded-lg"
            />
          </div>

          <div class="flex justify-end items-center">
            <FormField label="Image">
              <FormFilePicker
                label="Upload"
                @change="imageReaderOnChoose"
                hide-filename
              >
                <ButtonLoading v-if="imageReaderState.loading" />
              </FormFilePicker>
            </FormField>
          </div>

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
import { mdiBallotOutline, mdiCart, mdiCurrencyUsd, mdiPlus } from "@mdi/js";
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
import { useProductStore } from "@/stores/product";
import { useStore } from "@/stores/store";
import { useFileReaderImage } from "@/helpers/fileReaderImage";

const route = useRoute();

const router = useRouter();

const productStore = useProductStore();

const loading = computed(() => productStore.currentProduct.loading);

const initialState = {
  id: null,
  title: "",
  slug: null,
  price: null,
  description: null,
  published: false,
  created_at: null,
  updated_at: null,
  image: null,
  image_url: null,
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
        return await productStore.getProduct(route.params.id);
      } catch (error) {
        return router.push({ name: "app.products.create" });
      }
    })();
  }
};

(() => {
  checkPage();
})();

watch(
  () => productStore.currentProduct.data,
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
    const { data } = await productStore.saveProduct(form);
    router.push({
      name: "app.products.view",
      params: { id: data.data.id },
    });
    useStore().notify({
      type: "success",
      message: "Product was successfully saved.",
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
