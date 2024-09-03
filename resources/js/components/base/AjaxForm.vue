<template>
  <form ref="formRef" @submit="submitHandler">
    <slot v-bind="{ errors, res, loading }" />
  </form>
</template>
<script setup>
import axios, { isAxiosError } from "axios";
import { ref } from "vue";
import { success as successAlert, error as errorAlert } from "../../alerts";

const formRef = ref(null);
const res = ref({});
const errors = ref({});
const loading = ref(false);

const { action, method } = defineProps({
  method: {
    type: String,
    default: "post",
  },
  action: {
    type: String,
    required: true,
  },
});

async function submitHandler(event) {
  event.preventDefault();
  res.value = {};
  errors.value = {};
  loading.value = true;
  try {
    const formData = new FormData(formRef.value);
    formData.append("_method", method);

    const response = await axios.post(action, formData);

    res.value = response.data;

    formRef.value.reset();

    await successAlert();

    // handle redirects
    if (response.request.responseURL !== action) {
      location.href = response.request.responseURL;
    }
  } catch (_error) {
    if (isAxiosError(_error) && _error.response.status == 422) {
      errors.value = _error.response.data.errors;
    }

    console.error(_error);

    await errorAlert();
  }

  loading.value = false;
}
</script>
