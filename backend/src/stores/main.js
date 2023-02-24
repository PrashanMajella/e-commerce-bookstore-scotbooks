import { defineStore } from "pinia";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import adminAvatar from "@/assets/images/admin.png";

export const useMainStore = defineStore("main", {
  state: () => ({
    /* User */
    userName: null,
    userEmail: null,
    userAvatar: null,

    /* Field focus with ctrl+k (to register only once) */
    isFieldFocusRegistered: false,

    /* Sample data (commonly used) */
    clients: [],
    history: [],
  }),
  actions: {
    setUser(payload) {
      const authStore = useAuthStore();

      if (payload.name) {
        this.userName = authStore.user.data.name;
      }
      if (payload.email) {
        this.userEmail = authStore.user.data.email;
      }
      if (payload.avatar) {
        this.userAvatar = adminAvatar;
      }
    },

    fetch(sampleDataKey) {
      axios
        .get(`data-sources/${sampleDataKey}.json`)
        .then((r) => {
          if (r.data && r.data.data) {
            this[sampleDataKey] = r.data.data;
          }
        })
        .catch((error) => {
          alert(error.message);
        });
    },
  },
});
