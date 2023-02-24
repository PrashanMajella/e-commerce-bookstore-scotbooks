<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title + ' Table'" main>
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
        <template v-if="products.length">
          <!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
            <b>Responsive table.</b> Collapses on mobile
          </NotificationBar> -->

          <CardBox class="mb-6" has-table>
            <TableProducts checkable :list="products" />
          </CardBox>
        </template>


        <template v-else>
          <SectionTitleLineWithButton :icon="mdiTableOff" title="Empty variation" />

          <NotificationBar color="danger" :icon="mdiTableOff">
            <b>Products table</b> is Empty!
          </NotificationBar>
          <CardBox>
            <CardBoxComponentEmpty />
          </CardBox>
        </template>
      </template>

    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import { mdiMonitorCellphone, mdiTableBorder, mdiTableOff, mdiPlus, } from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import TableProducts from "@/components/custom/TableProducts.vue";
import CardBox from "@/components/CardBox.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/BaseButton.vue";
import PageLoader from "@/components/custom/PageLoader.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import { useProductStore } from "@/stores/product";
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const productStore = useProductStore();

const products = computed(() => productStore.products.data);

const loading = computed(() => productStore.products.loading);

(async () => {
  try {
    return await productStore.getProducts();
  } catch (error) {
    return error;
  }
})();
</script>
