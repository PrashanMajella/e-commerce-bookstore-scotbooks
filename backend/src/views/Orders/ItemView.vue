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

          <SectionTitle first>Billing Information</SectionTitle>
          <FormField label="First & Last Name">
            <FormControl
              v-model="form.billing.first_name"
              :icon="mdiAccount"
              placeholder="First Name"
              disabled
            />
            <FormControl
              v-model="form.billing.last_name"
              :icon="mdiAccount"
              placeholder="Last Name"
              disabled
            />
          </FormField>

          <FormField label="Phone & Email">
            <FormControl
              v-model="form.billing.phone"
              :icon="mdiPhone"
              placeholder="Phone"
              disabled
            />
            <FormControl
              v-model="form.billing.email"
              type="email"
              :icon="mdiAt"
              placeholder="Email"
              disabled
            />
          </FormField>

          <FormField label="Address 1">
            <FormControl
              v-model="form.billing.address1"
              :icon="mdiMapMarker"
              placeholder="Address 1"
              disabled
            />
          </FormField>

          <FormField label="Address 2">
            <FormControl
              v-model="form.billing.address2"
              :icon="mdiMapMarker"
              placeholder="Address 2"
              disabled
            />
          </FormField>

          <FormField label="City & Zip Code">
            <FormControl
              v-model="form.billing.city"
              :icon="mdiCityVariant"
              placeholder="City"
              disabled
            />
            <FormControl
              v-model="form.billing.zip_code"
              :icon="mdiOfficeBuildingMarker"
              placeholder="Zip Code"
              disabled
            />
          </FormField>

          <FormField label="Country & State">
            <FormControl
              v-model="form.billing.country_code"
              :icon="mdiFlag"
              placeholder="Country"
              disabled
            />
            <FormControl
              v-model="form.billing.state"
              :icon="mdiFlagCheckered"
              placeholder="State"
              disabled
            />
          </FormField>

          <BaseDivider />


          <SectionTitle first>Shipping Information</SectionTitle>
          <FormField label="First & Last Name">
            <FormControl
              v-model="form.shipping.first_name"
              :icon="mdiAccount"
              placeholder="First Name"
              disabled
            />
            <FormControl
              v-model="form.shipping.last_name"
              :icon="mdiAccount"
              placeholder="Last Name"
              disabled
            />
          </FormField>

          <FormField label="Phone & Email">
            <FormControl
              v-model="form.shipping.phone"
              :icon="mdiPhone"
              placeholder="Phone"
              disabled
            />
            <FormControl
              v-model="form.shipping.email"
              type="email"
              :icon="mdiAt"
              placeholder="Email"
              disabled
            />
          </FormField>

          <FormField label="Address 1">
            <FormControl
              v-model="form.shipping.address1"
              :icon="mdiMapMarker"
              placeholder="Address 1"
              disabled
            />
          </FormField>

          <FormField label="Address 2">
            <FormControl
              v-model="form.shipping.address2"
              :icon="mdiMapMarker"
              placeholder="Address 2"
              disabled
            />
          </FormField>

          <FormField label="City & Zip Code">
            <FormControl
              v-model="form.shipping.city"
              :icon="mdiCityVariant"
              placeholder="City"
              disabled
            />
            <FormControl
              v-model="form.shipping.zip_code"
              :icon="mdiOfficeBuildingMarker"
              placeholder="Zip Code"
              disabled
            />
          </FormField>

          <FormField label="Country & State">
            <FormControl
              v-model="form.shipping.country_code"
              :icon="mdiFlag"
              placeholder="Country"
              disabled
            />
            <FormControl
              v-model="form.shipping.state"
              :icon="mdiFlagCheckered"
              placeholder="State"
              disabled
            />
          </FormField>

          <BaseDivider />

          <SectionTitle first>Order Items</SectionTitle>
          <TableOrderItems checkable :list="form.order_items" />

          <BaseDivider />

          <div class="flex flex-col items-end justify-end my-5">
              <div class="grid grid-cols-2 gap-2 text-lg font-semibold capitalize">
                  <h2 class="text-gray-500">Subtotal:</h2>
                  <span>{{ "$" + form.total_price }}</span>
                  <h2 class="text-gray-500">Payment Status:</h2>
                  <span>{{ form.order.status }}</span>
              </div>
          </div>

          <BaseDivider />


          <FormField label="Order Status">
            <template v-if="(form.order.status !== 'cancelled') && (form.order.status !== 'unpaid')">
              <select name="order-status" id="order-status" v-model="updateStatus.status" class="capitalize">
                <template v-for="(items, index) in form.order_statuses" :key="index">
                  <option :value="items">{{ items }}</option>
                </template>
              </select>
            </template>
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
import TableOrderItems from "@/components/custom/TableOrderItems.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import ButtonLoading from "@/components/custom/ButtonLoading.vue";
import PageLoader from "@/components/custom/PageLoader.vue";
import { useRoute, useRouter } from "vue-router";
import { useOrderStore } from "@/stores/order";
import { useStore } from "@/stores/store";
import { useFileReaderImage } from "@/helpers/fileReaderImage";

const route = useRoute();

const router = useRouter();

const orderStore = useOrderStore();

const loading = computed(() => orderStore.currentOrder.loading);

const initialState = {
  order: {
    id: null,
    total_price: null,
    status: null,
    created_by: null,
    updated_by: null,
    created_at: null,
    updated_at: null,
  },
  order_items: [],
  order_statuses: [],
  total_price: null,
  billing: {
    id: null,
    first_name: null,
    last_name: null,
    email: null,
    phone: null,
    address1: null,
    address2: null,
    city: null,
    state: null,
    zip_code: null,
    country_code: null,
    customer_id: null,
    order_id: null,
    created_at: null,
    updated_at: null,
  },
  shipping: {
    id: null,
    first_name: null,
    last_name: null,
    email: null,
    phone: null,
    address1: null,
    address2: null,
    city: null,
    state: null,
    zip_code: null,
    country_code: null,
    customer_id: null,
    order_id: null,
    created_at: null,
    updated_at: null,
  },
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

const updateStatus = reactive({ id: 0, status: ""})

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
        return await orderStore.getOrder(route.params.id);
      } catch (error) {
        return router.push({ name: "app.orders" });
      }
    })();
  }
};

(() => {
  checkPage();
})();

watch(
  () => orderStore.currentOrder.data,
  (newVal, oldVal) => {
    Object.assign(form, JSON.parse(JSON.stringify(newVal)));
    Object.assign(updateStatus, { id: form.order.id, status: form.order.status });
  }
);

const submit = async () => {
  try {
    const { data } = await orderStore.saveOrder(updateStatus);
    router.push({
      name: "app.orders.view",
      params: { id: data.order.id },
    });
    useStore().notify({
      type: "success",
      message: "Order was successfully saved.",
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
