<template>
  <LayoutGuest>
    <SectionFullScreen v-slot="{ cardClass }" bg="purplePink">
      <CardBox :class="cardClass" is-form @submit.prevent="submit">
        <h1 class="flex items-center justify-center text-2xl mb-5">{{ route.meta.title }}</h1>
        <div v-if="errorMessage" class="flex items-center justify-center text-red-500">{{ errorMessage }}</div>
        <FormField label="Email" help="Please enter your email">
          <FormControl
            v-model="form.email"
            :icon="mdiAccount"
            type="email"
            name="email"
            autocomplete="email"
          />
        </FormField>

        <FormField label="Password" help="Please enter your password">
          <FormControl
            v-model="form.password"
            :icon="mdiAsterisk"
            type="password"
            name="password"
            autocomplete="current-password"
          />
        </FormField>

        <FormCheckRadio
          v-model="form.remember"
          name="remember"
          label="Remember"
          :input-value="true"
        />

        <template #footer>
          <BaseButtons>
            <BaseButton type="submit" color="info" label="Login" />
          </BaseButtons>
        </template>
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { mdiAccount, mdiAsterisk } from "@mdi/js";
import SectionFullScreen from "@/components/SectionFullScreen.vue";
import CardBox from "@/components/CardBox.vue";
import FormCheckRadio from "@/components/FormCheckRadio.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import LayoutGuest from "@/layouts/LayoutGuest.vue";
import { useAuthStore } from "@/stores/auth";

const route = useRoute();

const form = reactive({
  email: null,
  password: null,
  remember: false,
});

const router = useRouter();

const authStore = useAuthStore();

const loading = ref(false);

const errorMessage = ref(null);

const submit = async () => {
  loading.value = true;
  try {
    const response = await authStore.login(form);
    router.push({ name: "app" });
    return response;
  } catch (error) {
    errorMessage.value = error.response.data.message;
    return error;
  } finally {
    loading.value = false;
  }
};
</script>


