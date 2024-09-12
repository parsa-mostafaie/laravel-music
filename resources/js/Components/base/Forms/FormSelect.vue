<template>
  <select
    v-bind="$attrs"
    :disabled="loading"
    :name="name"
    :id="name"
    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
  >
    <slot />
    <option
      :value="value"
      :selected="model == value"
      v-for="(text, value) in options"
    >
      {{ text }}
    </option>
  </select>
  <input-error v-if="errors[name]" :message="errors[name]"></input-error>
</template>
<script setup>
import InputError from "./InputError.vue";

const model = defineModel();
const { options, loading, errors, res, name } = defineProps([
  "options",
  "loading",
  "errors",
  "res",
  "name",
]);
</script>

<!--
  {
    {id}: {name},
    {value}: {text}
  }
-->
