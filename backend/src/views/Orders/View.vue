<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title + ' Table'" main>
      </SectionTitleLineWithButton>

      <PageLoader v-if="loading"/>

      <template v-else>
        <template v-if="orders.length">
          <CardBox class="mb-6" has-table>
            <TableOrders checkable :list="orders" />
          </CardBox>
        </template>


        <template v-else>
          <SectionTitleLineWithButton :icon="mdiTableOff" title="Empty variation" />

          <NotificationBar color="danger" :icon="mdiTableOff">
            <b>Orders table</b> is Empty!
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
import TableOrders from "@/components/custom/TableOrders.vue";
import CardBox from "@/components/CardBox.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import PageLoader from "@/components/custom/PageLoader.vue";
import { useOrderStore } from "@/stores/order";
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const orderStore = useOrderStore();

const orders = computed(() => orderStore.orders.data);

const loading = computed(() => orderStore.orders.loading);

(async () => {
  try {
    return await orderStore.getOrders();
  } catch (error) {
    return error;
  }
})();
</script>
