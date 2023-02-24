import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const axiosClient = axios.create({
  baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`
});

axiosClient.interceptors.request.use((config) => {
  const authStore = useAuthStore();

  config.headers.Authorization = `Bearer ${authStore.user.token}`;
  return config;
});

axiosClient.interceptors.response.use((response) => {
  return response;
}, (error) => {
  const router = useRouter();
  const authStore = useAuthStore();

  if (error.response.status === 401) {
    authStore.removeToken();
    router.push({ name: "auth" });
  } else {
    throw error;
  }
});

export default axiosClient;
