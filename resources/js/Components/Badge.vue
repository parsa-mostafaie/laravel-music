<template>
  <component :is="currentBadgeComponent"><slot /></component>
</template>

<script setup>
import { defineAsyncComponent, ref, shallowRef, watch, watchEffect } from "vue";
import { capitalizeFirstLetter } from "@/helpers";

const props = defineProps({
  variant: {
    type: String,
    default: "default",
  },
});

const currentBadgeComponent = shallowRef(null);

watchEffect(async () => {
  const normalizedVariant = capitalizeFirstLetter(props.variant);
  currentBadgeComponent.value = defineAsyncComponent(() =>
    import(`./Badges/${normalizedVariant}Badge.vue`)
  );
});
</script>
