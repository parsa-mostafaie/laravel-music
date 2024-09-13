<template>
  <!-- This is an example component -->
  <div class="p-3 flex justify-center">
    <Card class="flex justify-start px-3 items-center sm:flex-row flex-col">
      <template #image v-if="artist.image_url">
        <div class="p-5 min-w-[200px]">
          <img
            class="rounded-full"
            width="200"
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
        <default-badge class="-mx-6">{{artist.follower_count}} Followers</default-badge>
      </template>
    </Card>
  </div>
</template>
<script setup>
import { ref } from "vue";
import Card from "./Card.vue";
import AjaxButton from "./base/AjaxButton.vue";
import DefaultBadge from './Badges/DefaultBadge.vue';

const props = defineProps(["artist"]);

const artist = ref(props.artist);

function refresh(response) {
  artist.value = response.data;
}
</script>
