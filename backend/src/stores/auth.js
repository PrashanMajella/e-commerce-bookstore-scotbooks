import { defineStore } from "pinia";
import axiosClient from "@/api/axios";

export const useAuthStore = defineStore("auth", {
  state: () => {
    return {
      user: {
        data: JSON.parse(sessionStorage.getItem("USER")),
        token: sessionStorage.getItem("TOKEN")
      }
    }
  },
  getters: {},
  actions: {
    setUser(user) {
      this.$patch((state) => {
        if (user) {
          sessionStorage.setItem("USER", JSON.stringify(user));
          state.user.data = user;
        } else {
          sessionStorage.removeItem("USER");
          state.user.data = null;
        }
      });
    },
    setToken(token) {
      this.$patch((state) => {
        if (token) {
          sessionStorage.setItem("TOKEN", token);
          state.user.token = token;
        } else {
          sessionStorage.removeItem("TOKEN");
          state.user.token = null;
        }
      });
    },
    async login(user) {
      try {
        const { data } = await axiosClient.post("/login", user);
        this.setUser(data.user);
        this.setToken(data.token);
        return data;
      } catch(error) {
        throw error;
      }
    },
    async getUser(user) {
      try {
        const { data } = await axiosClient.get("/user", user);
        this.setUser(data);
        return data;
      } catch(error) {
        throw error;
      }
    },
    removeUser() {
      this.setUser(null);
      this.setToken(null);
    },
    removeToken() {
      this.removeUser();
    },
    async logout() {
      try {
        const response = await axiosClient.post("/logout");
        this.removeUser();
        return response;
      } catch(error) {
        throw error;
      }
    }
  }
});
