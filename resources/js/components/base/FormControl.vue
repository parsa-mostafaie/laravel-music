<template>
  <input
    type="text"
    :disabled="loading"
    :class="{
      'form-control': true,
      'is-invalid': errors[name] || false,
    }"
    :name="name"
    :id="name"
  />
  <pre class="invalid-feedback" v-if="errors[name]">{{
    errors[name].flat().join("\n")
  }}</pre>
</template>
<script setup>
const { errors, res, loading, name } = defineProps([
  "errors",
  "res",
  "loading",
  "name",
]);
</script>
