import { defineStore } from "pinia";
import axiosClient from "@/api/axios";

export const useDashboardStore = defineStore("dashboard", {
  state: () => {
    return {
      dashboard: {
        loading: false,
        data: {},
      },
    };
  },
  getters: {},
  actions: {
    setDashboard(dashboard) {
      this.$patch((state) => {
        state.dashboard.data = dashboard
      });
    },
    setDashboardLoading(loading) {
      this.$patch((state) => {
        state.dashboard.loading = loading;
      });
    },
    async getDashboard() {
      this.setDashboardLoading(true);
      try {
        const { data } = await axiosClient.get("/dashboard");
        this.setDashboard(data);
        return data;
      } catch (error) {
        throw error;
      } finally {
        this.setDashboardLoading(false);
      }
    },
  }
});
