<template>
  <LayoutGuest>
    <SectionFullScreen v-slot="{ cardClass }" bg="pinkRed">
      <section
        class="py-24 px-6 lg:px-0 lg:max-w-2xl lg:mx-auto text-center"
        :class="{ '-mb-6': first, '-mt-6': last, '-my-6': !first && !last }"
      >
        <div class="flex flex-col items-center">
          <h1 class="text-8xl text-white dark:text-slate-400 font-bold">
          404
        </h1>
        <h2 class="text-2xl text-white dark:text-slate-400">
          Page Not Found!
        </h2>

        <br class="mb-5">

        <BaseButtons>
          <BaseButton
            label="HOMEPAGE"
            color="contrast"
            :to="{ name: 'root' }"
          />
        </BaseButtons>

        </div>
      </section>
    </SectionFullScreen>
  </LayoutGuest>
</template>

<script setup>
import SectionFullScreen from "@/components/SectionFullScreen.vue";
import CardBox from "@/components/CardBox.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import LayoutGuest from "@/layouts/LayoutGuest.vue";

import {
  mdiContrastCircle,
  mdiInformation,
  mdiCheckCircle,
  mdiAlert,
  mdiAlertCircle,
  mdiOpenInNew,
  mdiClose,
  mdiReload,
  mdiTrendingUp,
} from "@mdi/js";

const first = true;
const last = true;

</script>

