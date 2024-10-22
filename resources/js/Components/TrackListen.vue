<template>
  <div class="p-3 flex justify-center">
    <Card class="flex-col max-w-full sm:max-w-[75%] md:max-w-[50%]">
      <template #image v-if="track.image_url">
        <div class="relative">
          <img
            class="d-block rounded-lg max-w-full"
            :src="track.image_url"
            alt="Image"
          />

          <category-chaining
            class="absolute top-1 left-1"
            :category="track.category"
          />
        </div>
      </template>
      <template #header>
        <div class="flex font-normal justify-between items-center">
          <span class="font-bold">{{ track.name }}</span>
          <default-badge class="m-0 rounded-full">
            <a
              :href="track.artist.profile_url"
              class="flex items-center text-base gap-1"
            >
              <img
                :src="track.artist.image_url"
                class="h-5 w-auto rounded-lg object-cover"
                alt="Artist Profile"
              />
              {{ track.artist.name }}
            </a>
          </default-badge>
        </div>
      </template>
      <p class="sm:max-w-[90%] text-justify">
        <template v-if="track.summary">{{ track.summary }}</template>
        <i v-else>No Summary is Provided!</i>
      </p>
      <p class="text-xl text-slate-300 font-bold">Lyric</p>
      {{ track.lyric }}
    </Card>
  </div>
</template>
<script setup>
import CategoryChaining from "./CategoryChaining.vue";
import DefaultBadge from "./Badges/DefaultBadge.vue";
import Card from "./Card.vue";

defineProps(["track"]);
</script>
