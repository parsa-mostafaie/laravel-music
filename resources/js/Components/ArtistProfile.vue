<template>
  <!-- This is an example component -->
  <div class="p-5 flex flex-col items-center">
    <Card class="items-center sm:flex-row flex-col">
      <template #image v-if="artist.image_url">
        <div class="p-5">
          <img
            class="min-h-[200px] min-w-[200px] rounded-full"
            width="200"
            height="200"
            :src="artist.image_url"
            alt="Image"
          />
        </div>
      </template>
      <template #header>
        <div class="flex justify-between w-100">
          <h5>
            {{ artist.name }}
          </h5>
          <div class="flex gap-1" v-if="$page.props.auth.user">
            <ajax-button
              variant="secondary"
              method="post"
              :href="route('api.follow', { artist })"
              v-if="!artist.followed"
              @refresh="refresh"
            >
              Follow
            </ajax-button>
            <ajax-button
              variant="danger"
              method="post"
              :href="route('api.unfollow', { artist })"
              v-else
              @refresh="refresh"
            >
              Unfollow
            </ajax-button>
          </div>
        </div>
      </template>
      <p class="sm:max-w-[90%] text-justify">
        <template v-if="artist.bio">{{ artist.bio }}</template>
        <i v-else>No Biography is Provided!</i>
      </p>
      <template #footer>
        <default-badge class="-mx-6"
          >{{ artist.followers_count || "No" }} Followers</default-badge
        >
      </template>
    </Card>
    <div v-if="artist.latest_tracks.length || 0">
      <p
        class="text-center font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight mt-5"
      >
        {{ artist.name }}'s Tracks
      </p>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 grid-wrap">
        <TrackListen
          v-for="track in artist.latest_tracks"
          :key="track.id"
          :track
          @refresh="listenUpdate"
          class="max-w-sm"
        />
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, watchEffect } from "vue";
import Card from "./Card.vue";
import AjaxButton from "./base/AjaxButton.vue";
import DefaultBadge from "./Badges/DefaultBadge.vue";
import { router } from "@inertiajs/vue3";
import TrackListen from "./TrackListen.vue";

const props = defineProps(["artist"]);

const artist = ref(props.artist);

watchEffect(() => {
  artist.value = props.artist; // Automatically updates when props.artist changes
});

function refresh(response) {
  artist.value = response.data;
}

function listenUpdate(response, prev_track, ignore, force_ignore) {
  // force ignore means artist action for now (may changed in future)
  if (!force_ignore) {
    const prev_artist = prev_track.value.artist;
    const current_artist = response.data.artist;

    if (
      prev_artist.id == current_artist.id &&
      prev_artist.ifollowed == current_artist.followed
    )
      return;
  }

  router.reload();

  ignore();
}
</script>
