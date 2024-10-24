<template>
  <div class="flex gap-1">
    <CategoryChaining :category="category.parent" v-if="category.parent" />
    <Link :href="category.url">
      <default-badge class="!mx-0">
        {{ category.name }}
      </default-badge>
    </Link>
  </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import DefaultBadge from "./Badges/DefaultBadge.vue";
defineProps(["category"]);
</script>
