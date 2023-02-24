import { defineStore } from "pinia";
import axiosClient from "@/api/axios";
import image_empty from "../assets/images/image_empty.jpg";

export const useStore = defineStore("store", {
  state: () => {
    return {
      assets: {
        image: {
          emptyItem: image_empty,
        }
      },
      notification: {
        show: false,
        type: null,
        message: null
      }
    };
  },
  getters: {},
  actions: {
    notify({ type, message }) {
      this.$patch((state) => {
        state.notification.show = true;
        state.notification.type = type;
        state.notification.message = message;
        setTimeout(() => {
          state.notification.show = false;
        }, 3500);
      });
    }
  }
});
