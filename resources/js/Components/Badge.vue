<template>
  <component :is="badgeComponent"><slot /></component>
</template>

<script setup>
import { computed, defineAsyncComponent } from "vue";
import { capitalizeFirstLetter } from "@/helpers";

// Define a prop for color
const props = defineProps({
  variant: {
    type: String,
    default: "default",
  },
});

// Create a computed property to determine which badge component to load
const badgeComponent = computed(() => {
  return defineAsyncComponent(() =>
    import(`./Badges/${capitalizeFirstLetter(props.variant)}Badge.vue`)
  );
});
</script>
