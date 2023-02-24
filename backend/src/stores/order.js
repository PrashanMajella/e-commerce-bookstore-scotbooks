import { defineStore } from "pinia";
import axiosClient from "@/api/axios";

export const useOrderStore = defineStore("order", {
  state: () => {
    return {
      orders: {
        loading: false,
        data: [],
        links: {},
        meta: {}
      },
      currentOrder: {
        loading: false,
        data: {}
      },
    };
  },
  getters: {},
  actions: {
    setOrders(orders) {
      this.$patch((state) => {
        state.orders = orders
      });
    },
    setCurrentOrder(order) {
      this.$patch((state) => {
        state.currentOrder.data = order;
      });
    },
    setOrdersLoading(loading) {
      this.$patch((state) => {
        state.orders.loading = loading;
      });
    },
    setCurrentOrderLoading(loading) {
      this.$patch((state) => {
        state.currentOrder.loading = loading;
      });
    },
    async saveOrder(order) {
      this.setCurrentOrderLoading(true);
      if (order.id) {
        try {
          const result = await axiosClient.put(`/orders/${order.id}`, order);
          this.setCurrentOrder(result.data);
          return result;
        } catch (error) {
          throw error;
        } finally {
          this.setCurrentOrderLoading(false);
          this.getOrders();
        }
      }
      return;
    },
    async getOrder(id) {
      this.setCurrentOrderLoading(true);
      try {
        const result = await axiosClient.get(`/orders/${id}`);
        this.setCurrentOrder(result.data);
        return result;
      } catch (error) {
        throw error;
      } finally {
        this.setCurrentOrderLoading(false);
      }
    },
    async getOrders() {
      this.setOrdersLoading(true);
      try {
        const { data } = await axiosClient.get("/orders");
        this.setOrders(data);
        return data;
      } catch (error) {
        throw error;
      } finally {
        this.setOrdersLoading(false);
      }
    },
  }
});
