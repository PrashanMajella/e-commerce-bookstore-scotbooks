<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiChartTimelineVariant"
        title="Overview"
        main
      >
        <BaseButton
          href="https://github.com/"
          target="_blank"
          :icon="mdiGithub"
          label="Star on GitHub"
          color="contrast"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <CardBoxWidget
          :trend="Math.round((dashboard.clients / dashboard.users) * 100) + '%'"
          trend-type="up"
          :to="{ name: 'root' }"
          color="text-blue-500"
          :icon="mdiAccountMultiple"
          :number="dashboard.clients"
          label="Clients"
        />
        <CardBoxWidget
          :trend="Math.round((dashboard.new_orders / dashboard.orders) * 100) + '%'"
          trend-type="up"
          color="text-emerald-500"
          :icon="mdiCash"
          :number="toNumber(dashboard.sales)"
          prefix="$"
          label="Sales"
        />

        <CardBoxWidget
          :trend="Math.round((dashboard.payments / dashboard.orders) * 100) + '%'"
          trend-type="up"
          color="text-pink-500"
          :icon="mdiAccountCreditCard"
          :number="dashboard.payments"
          label="Payments"
        />

        <CardBoxWidget
          :trend="Math.round((dashboard.new_orders / dashboard.orders) * 100) + '%'"
          trend-type="up"
          color="text-green-500"
          :icon="mdiCartArrowDown"
          :number="dashboard.new_orders"
          label="New Orders"
        />
        <CardBoxWidget
          :trend="Math.round((dashboard.new_messages / dashboard.messages) * 100) + '%'"
          trend-type="up"
          color="text-sky-500"
          :icon="mdiForum"
          :number="dashboard.new_messages"
          label="New Messages"
        />
        <CardBoxWidget
          :trend="Math.round((dashboard.users / dashboard.users) * 100) + '%'"
          trend-type="up"
          color="text-blue-500"
          :icon="mdiAccountGroupOutline"
          :number="dashboard.users"
          label="Users"
        />
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="flex flex-col justify-between">
          <CardBoxTransaction
            v-for="(transaction, index) in transactionBarItems"
            :key="index"
            :amount="transaction.amount"
            :date="transaction.date"
            :business="transaction.business"
            :type="transaction.type"
            :name="transaction.name"
            :account="transaction.account"
          />
        </div>
        <div class="flex flex-col justify-between">
          <CardBoxClient
            v-for="client in clientBarItems"
            :key="client.id"
            :name="client.name"
            :login="client.login"
            :date="client.created"
            :progress="client.progress"
          />
        </div>
      </div>

    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import { computed, ref, onMounted } from "vue";
import { useMainStore } from "@/stores/main";
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
  mdiAccountCreditCard,
  mdiReload,
  mdiGithub,
  mdiAccountGroupOutline,
  mdiForum,
  mdiCash,
  mdiCartArrowDown,
} from "@mdi/js";
import * as chartConfig from "@/components/Charts/chart.config.js";
import LineChart from "@/components/Charts/LineChart.vue";
import SectionMain from "@/components/SectionMain.vue";
import CardBoxWidget from "@/components/CardBoxWidget.vue";
import CardBox from "@/components/CardBox.vue";
import TableSampleClients from "@/components/TableSampleClients.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxTransaction from "@/components/CardBoxTransaction.vue";
import CardBoxClient from "@/components/CardBoxClient.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import SectionBannerStarOnGitHub from "@/components/SectionBannerStarOnGitHub.vue";
import { useRoute } from "vue-router";
import { useDashboardStore } from "@/stores/dashboard";
import { toNumber } from "@vue/shared";

const route = useRoute();

const dashboardStore = useDashboardStore();

const dashboard = computed(() => dashboardStore.dashboard.data);

const loading = computed(() => dashboardStore.dashboard.loading);

(async () => {
  try {
    return await dashboardStore.getDashboard();
  } catch (error) {
    return error;
  }
})();

const chartData = ref(null);

const fillChartData = () => {
  chartData.value = chartConfig.sampleChartData();
};

onMounted(() => {
  fillChartData();
});

const mainStore = useMainStore();

const clientBarItems = computed(() => mainStore.clients.slice(0, 4));

const transactionBarItems = computed(() => mainStore.history);
</script>

