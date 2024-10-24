<template>
  <div class="flex gap-1">
    <CategoryChaining :category="category.parent" v-if="category.parent" />
    <a :href="category.url">
      <default-badge class="!mx-0">
        {{ category.name }}
      </default-badge>
    </a>
  </div>
</template>
<script setup>
import DefaultBadge from "./Badges/DefaultBadge.vue";
defineProps(["category"]);
</script>
