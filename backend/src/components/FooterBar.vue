<template>
  <footer class="py-2 px-6" :class="containerMaxW">
    <BaseLevel>
      <div class="text-center md:text-left">
        © Scotbooks™. All Rights Reserved.
        <slot />
      </div>
      <div class="md:py-2">
        <a href="#">
          <BrandLogo class="w-auto h-8 md:h-6" />
        </a>
      </div>
    </BaseLevel>
  </footer>
</template>

<script setup>
import { containerMaxW } from "@/assets/js/config.js";
import BaseLevel from "@/components/BaseLevel.vue";
import BrandLogo from "@/components/BrandLogo.vue";

const year = new Date().getFullYear();
</script>

