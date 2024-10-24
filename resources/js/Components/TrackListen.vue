<template>
  <div class="p-3 flex justify-center">
    <Teleport to="body" v-if="$page.props['is-manager']">
      <edit-track ref="edit_ref" @refresh="refreshTrack" />
    </Teleport>
    <Card class="flex-col w-full max-w-xl">
      <template #image v-if="track.image_url">
        <div class="relative">
          <img
            class="d-block rounded-lg max-w-full w-full"
            :src="track.image_url"
            alt="Image"
          />

          <category-chaining
            class="absolute top-1 left-1"
            :category="track.category"
          />

          <div class="absolute top-1 right-1" v-if="$page.props['is-manager']">
            <form-button @click="openEdit">Edit</form-button>
            <AjaxButton
              class="mx-1"
              :variant="track.published_at ? 'danger' : 'primary'"
              :href="route('api.tracks.publish', track)"
              :danger="!!track.published_at"
              method="put"
              @refresh="refreshTrack"
            >
              {{ track.published_at ? "Unpublish" : "Publish" }}
            </AjaxButton>
          </div>
        </div>
      </template>
      <template #header>
        <div class="flex font-normal justify-between items-center">
          <Link :href="track.listen_url" class="font-bold">{{
            track.name
          }}</Link>
          <Badge
            :variant="track.artist.followed ? 'green' : 'default'"
            class="m-0 rounded-full"
          >
            <Link
              :href="track.artist.profile_url"
              class="flex items-center text-base gap-1"
            >
              <img
                :src="track.artist.image_url"
                class="h-5 w-auto rounded-lg object-cover"
                alt="Artist Profile"
              />
              {{ track.artist.name }}
            </Link>
          </Badge>
        </div>
      </template>
      <p class="sm:max-w-[90%] text-justify">
        <template v-if="track.summary">{{ track.summary }}</template>
        <i v-else>No Summary is Provided!</i>
      </p>
      <p>
        <b>Time:</b> {{ track.time_string }}, <b>Quality:</b>
        {{ track.quality }}, <b>Size:</b> {{ track.size }}
      </p>
      <p class="text-xl text-slate-300 font-bold">Lyric</p>
      {{ track.lyric }}

      <audio controls class="mt-2 w-full">
        <source :src="track.file_url" :type="track.file_mime" />
      </audio>
    </Card>
  </div>
</template>
<script setup>
import FormButton from "./base/Forms/FormButton.vue";
import AjaxButton from "./base/AjaxButton.vue";
import EditTrack from "./Forms/EditTrack.vue";
import CategoryChaining from "./CategoryChaining.vue";
import Card from "./Card.vue";
import { ref, watchEffect } from "vue";
import { Link } from "@inertiajs/vue3";
import Badge from "./Badge.vue";

const props = defineProps(["track"]); // Keep track as props
const track = ref(props.track); // Create a local ref

watchEffect(() => {
  track.value = props.track; // Automatically updates when props.track changes
});

watchEffect(() => {
  console.log(track.value.artist.followed)
})

const edit_ref = ref(null);

function openEdit() {
  edit_ref.value.fill(track.value);
}

function refreshTrack(response) {
  track.value = response.data;
}
</script>
