import { defineStore } from "pinia";
import axiosClient from "@/api/axios";

export const useContactMessageStore = defineStore("contactMessage", {
  state: () => {
    return {
      contactMessages: {
        loading: false,
        data: [],
        links: {},
        meta: {}
      },
      currentContactMessage: {
        loading: false,
        data: {}
      },
    };
  },
  getters: {},
  actions: {
    setContactMessages(contactMessages) {
      this.$patch((state) => {
        state.contactMessages = contactMessages
      });
    },
    setCurrentContactMessage(contactMessage) {
      this.$patch((state) => {
        state.currentContactMessage.data = contactMessage;
      });
    },
    setContactMessagesLoading(loading) {
      this.$patch((state) => {
        state.contactMessages.loading = loading;
      });
    },
    setCurrentContactMessageLoading(loading) {
      this.$patch((state) => {
        state.currentContactMessage.loading = loading;
      });
    },
    async saveContactMessage(contactMessage) {
      this.setCurrentContactMessageLoading(true);
      if (contactMessage.id) {
        try {
          contactMessage = { id: contactMessage.id, seen: contactMessage.seen };
          const result = await axiosClient.put(`/contact-messages/${contactMessage.id}`, contactMessage);
          this.setCurrentContactMessage(result.data);
          return result;
        } catch (error) {
          throw error;
        } finally {
          this.setCurrentContactMessageLoading(false);
          this.getContactMessages();
        }
      }
      return;
    },
    async getContactMessage(id) {
      this.setCurrentContactMessageLoading(true);
      try {
        const result = await axiosClient.get(`/contact-messages/${id}`);
        this.setCurrentContactMessage(result.data);
        return result;
      } catch (error) {
        throw error;
      } finally {
        this.setCurrentContactMessageLoading(false);
      }
    },
    async getContactMessages() {
      this.setContactMessagesLoading(true);
      try {
        const { data } = await axiosClient.get("/contact-messages");
        this.setContactMessages(data);
        return data;
      } catch (error) {
        throw error;
      } finally {
        this.setContactMessagesLoading(false);
      }
    },
  }
});
