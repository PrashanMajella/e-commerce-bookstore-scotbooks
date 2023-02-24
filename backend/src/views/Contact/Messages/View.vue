<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title + ' Table'" main>
      </SectionTitleLineWithButton>

      <PageLoader v-if="loading"/>

      <template v-else>
        <template v-if="contactMessages.length">
          <CardBox class="mb-6" has-table>
            <TableContactMessages checkable :list="contactMessages" />
          </CardBox>
        </template>


        <template v-else>
          <SectionTitleLineWithButton :icon="mdiTableOff" title="Empty variation" />

          <NotificationBar color="danger" :icon="mdiTableOff">
            <b>Contact messages table</b> is Empty!
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
import TableContactMessages from "@/components/custom/TableContactMessages.vue";
import CardBox from "@/components/CardBox.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/BaseButton.vue";
import PageLoader from "@/components/custom/PageLoader.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import { useContactMessageStore } from "@/stores/contactMessage";
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const contactMessageStore = useContactMessageStore();

const contactMessages = computed(() => contactMessageStore.contactMessages.data);

const loading = computed(() => contactMessageStore.contactMessages.loading);

(async () => {
  try {
    return await contactMessageStore.getContactMessages();
  } catch (error) {
    return error;
  }
})();
</script>
