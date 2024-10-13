<template>
  <component :is="component_is" type="button" :disabled="loading">
    <slot>Submit</slot>
  </component>
</template>
<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { computed, toRefs } from "vue";

const cases = {
  primary: PrimaryButton,
  danger: DangerButton,
  secondary: SecondaryButton,
};

const component_is = computed(() => cases[variant.value ?? 'secondary']);

const props = defineProps([
  "errors",
  "res",
  "loading",
  "variant",
]);
const { loading, variant } = toRefs(props);
</script>
