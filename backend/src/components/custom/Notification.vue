<template>
  <div v-if="notification.show" class="fixed w-[300px] right-4 bottom-4 flex p-4 border-r-4 animate-fade-in-up z-50 rounded-l-lg" :class="[notification.type === 'success' ? 'bg-green-200 border-green-500 dark:bg-green-200' : 'bg-red-200 border-red-500 dark:bg-red-200']" role="alert">
    <svg class="flex-shrink-0 w-5 h-5" :class="[notification.type === 'success' ? 'text-green-700' : 'text-red-700']" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
    </svg>
    <div class="ml-3 text-sm font-medium" :class="[notification.type === 'success' ? 'text-green-700' : 'text-red-700']">
      {{ notification.message }}
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "@/stores/store";

const store = useStore();
const notification = computed(() => store.notification);
</script>
