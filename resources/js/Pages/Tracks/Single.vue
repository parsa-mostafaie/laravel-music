<template>
  <app-layout :title="`Listen to '${$page.props.track.name}'`">
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        {{ $page.props.track.name }}
      </h2>
    </template>
    <track-listen :track="$page.props.track" />
  </app-layout>
</template>
<script setup>
import TrackListen from "@/Components/TrackListen.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
</script>
