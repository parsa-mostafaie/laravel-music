<template>
  <app-layout :title="`${$page.props.artist.name}'s Profile`">
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        {{ $page.props.artist.name }}'s Profile
      </h2>
    </template>
    <artist-profile :artist="$page.props.artist" />
  </app-layout>
</template>
<script setup>
import ArtistProfile from "@/Components/ArtistProfile.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
</script>
