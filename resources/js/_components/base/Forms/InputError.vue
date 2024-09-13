<script setup>
defineProps({
  message: [String, Array],
});
</script>

<template>
  <div v-show="message">
    <p class="text-sm text-red-600 dark:text-red-400">
      {{ message instanceof Array ? message.flat().join("\n") : message }}
    </p>
  </div>
</template>
