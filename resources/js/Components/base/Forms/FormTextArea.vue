<template>
  <textarea
    :disabled="loading"
    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full"
    :name="name"
    :id="name"
    v-bind="$attrs"
    v-model="model"
  />
  <input-error :message="errors[name]" v-if="errors[name]"/>
</template>
<script setup>
import InputError from './InputError.vue';

const { errors, res, loading, name } = defineProps([
  "errors",
  "res",
  "loading",
  "name",
]);

const model = defineModel();
</script>
