<template>
  <text-input
    :disabled="loading"
    :name="name"
    :id="name"
    v-bind="$attrs"
    v-model="model"
  />
  <input-error v-if="errors[name]" :message="errors[name]"></input-error>
</template>
<script setup>
import TextInput from './TextInput.vue';
import InputError from './InputError.vue';

const { errors, res, loading, name } = defineProps([
  "errors",
  "res",
  "loading",
  "name",
]);

const model = defineModel();
</script>
