<template>
  <component :is="component_is" type="button" :disabled="loading">
    <slot>Submit</slot>
  </component>
</template>
<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { computed } from "vue";

const cases = {
  primary: PrimaryButton,
  danger: DangerButton,
  secondary: SecondaryButton,
};

const component_is = computed(() => cases[variant ?? 'secondary']);

const { errors, res, loading, variant } = defineProps([
  "errors",
  "res",
  "loading",
  "variant",
]);
</script>
