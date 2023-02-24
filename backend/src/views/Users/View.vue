<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title + ' Table'" main>
      </SectionTitleLineWithButton>

      <PageLoader v-if="loading"/>

      <template v-else>
        <template v-if="users.length">
          <CardBox class="mb-6" has-table>
            <TableUsers checkable :list="users" />
          </CardBox>
        </template>
        
        <template v-else>
          <SectionTitleLineWithButton :icon="mdiTableOff" title="Empty variation" />

          <NotificationBar color="danger" :icon="mdiTableOff">
            <b>Users table</b> is Empty!
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
import TableUsers from "@/components/custom/TableUsers.vue";
import CardBox from "@/components/CardBox.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/BaseButton.vue";
import PageLoader from "@/components/custom/PageLoader.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import { useUserStore } from "@/stores/user";
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const userStore = useUserStore();

const users = computed(() => userStore.users.data);

const loading = computed(() => userStore.users.loading);

(async () => {
  try {
    return await userStore.getUsers();
  } catch (error) {
    return error;
  }
})();
</script>
