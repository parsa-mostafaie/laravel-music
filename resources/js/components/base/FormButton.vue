<template>
  <button type="button" :disabled="loading" class="btn">
    <slot>Submit</slot>
  </button>
</template>
<script setup>
const { errors, res, loading } = defineProps(["errors", "res", "loading"]);
</script>
