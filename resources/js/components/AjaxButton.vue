<template>
  <button :class="`btn btn-${color} btn-sm`" @click="handleClick">
    <slot>Click Me!</slot>
  </button>
</template>

<script setup>
import axios from "axios";

const { href, color, method } = defineProps({
  href: {
    type: String,
    required: true,
  },
  method: {
    type: String,
    default: "GET",
  },
  color: {
    type: String,
    default: "primary",
  },
});

const emit = defineEmits(["refresh"]);

async function handleClick() {
  try {
    await axios.request({
      method: method.toUpperCase(),
      url: href,
      withCredentials: true,
    });
    emit("refresh");
  } catch (error) {
    console.error(error);
  }
}
</script>
