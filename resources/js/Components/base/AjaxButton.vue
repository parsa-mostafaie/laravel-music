<template>
  <form-button :variant="color" v-bind="$attrs" @click="handleClick">
    <slot>Click Me!</slot>
  </form-button>
</template>

<script setup>
import axios from "axios";
import { toRefs } from "vue";
import {
  cancel as cancel_alert,
  dangerWork,
  error as error_alert,
  success as success_alert,
} from "../../alerts";
import FormButton from "./Forms/FormButton.vue";

const props = defineProps({
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
  danger: {
    type: Boolean,
    default: false,
  },
});
const { href, color, method, danger } = toRefs(props);

const emit = defineEmits(["refresh"]);

async function handleClick() {
  try {
    async function handler() {
      const res = await axios.request({
        method: method.value.toUpperCase(),
        url: href.value,
      });

      emit("refresh", res);
    }

    if (danger.value) {
      const res = await dangerWork();

      if (!res.isConfirmed) return cancel_alert();
    }

    await handler();

    return success_alert();
  } catch (error) {
    console.error(error);
    error_alert();
  }
}
</script>
