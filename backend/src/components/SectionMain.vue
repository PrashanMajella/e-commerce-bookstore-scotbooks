<template>
  <section class="p-6" :class="containerMaxW">
    <slot />
  </section>
</template>

<script setup>
import { containerMaxW } from "@/assets/js/config.js";
</script>
