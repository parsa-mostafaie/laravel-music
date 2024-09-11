<template>
  <input
    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
    :id="name"
    :name="name"
    v-bind="$attrs"
    :disabled="loading"
    type="file"
  />
  <input-error v-if="errors[name]" :message="errors[name]"></input-error>
</template>
<script setup>
import InputError from "./InputError.vue";

const { errors, res, loading, name } = defineProps([
  "errors",
  "res",
  "loading",
  "name",
]);
</script>
