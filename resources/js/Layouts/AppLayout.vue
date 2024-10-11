<script setup>
import { Head } from "@inertiajs/vue3";
import Banner from "@/Components/Banner.vue";
import ThemeToggle from "@/Components/ThemeToggle.vue";

defineProps({
  title: String,
});

import Navigation from "@/Components/Layout/App/Navigation.vue";
</script>

<template>
  <div>
    <Head :title="title" />
    <theme-toggle/>

    <Banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <Navigation />

      <!-- Page Heading -->
      <header v-if="$slots.header" class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
