<template>
  <!-- This is an example component -->
  <div class="p-3 flex justify-center">
    <Card class="flex-col">
      <template #image v-if="track.image_url">
        <img class="d-block rounded-lg h-[200px]" :src="track.image_url" alt="Image" />
      </template>
      <template #header>
          <h5>
            {{ track.name }}
          </h5>
      </template>
      <p class="sm:max-w-[90%] text-justify">
        <template v-if="track.bio">{{ track.bio }}</template>
        <i v-else>No Biography is Provided!</i>
      </p>
    </Card>
  </div>
</template>
<script setup>
import Card from "./Card.vue";

defineProps(["track"]);
</script>
