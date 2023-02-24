import { defineStore } from "pinia";
import axiosClient from "@/api/axios";

export const useUserStore = defineStore("user", {
  state: () => {
    return {
      users: {
        loading: false,
        data: [],
        links: {},
        meta: {}
      },
      currentUser: {
        loading: false,
        data: {}
      },
    };
  },
  getters: {},
  actions: {
    setUsers(users) {
      this.$patch((state) => {
        state.users = users
      });
    },
    setCurrentUser(user) {
      this.$patch((state) => {
        state.currentUser.data = user;
      });
    },
    setUsersLoading(loading) {
      this.$patch((state) => {
        state.users.loading = loading;
      });
    },
    setCurrentUserLoading(loading) {
      this.$patch((state) => {
        state.currentUser.loading = loading;
      });
    },
    async saveUser(user) {
      let result;

      this.setCurrentUserLoading(true);
      if (user.id) {
        try {
          user = { id: user.id, is_admin: user.is_admin };
          result = await axiosClient.put(`/users/${user.id}`, user);
          this.setCurrentUser(result.data);
          return result;
        } catch (error) {
          throw error;
        } finally {
          this.setCurrentUserLoading(false);
          this.getUsers();
        }
      } else {
        try {
          result = await axiosClient.post("/users", user);
          this.setCurrentUser(result.data);
          return result;
        } catch (error) {
          throw error;
        } finally {
          this.setCurrentUserLoading(false);
          this.getUsers();
        }
      }
    },
    async getUser(id) {
      this.setCurrentUserLoading(true);
      try {
        const result = await axiosClient.get(`/users/${id}`);
        this.setCurrentUser(result.data);
        return result;
      } catch (error) {
        throw error;
      } finally {
        this.setCurrentUserLoading(false);
      }
    },
    async getUsers() {
      this.setUsersLoading(true);
      try {
        const { data } = await axiosClient.get("/users");
        this.setUsers(data);
        return data;
      } catch (error) {
        throw error;
      } finally {
        this.setUsersLoading(false);
      }
    },
  }
});
