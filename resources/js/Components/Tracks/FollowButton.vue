<template>
  <ajax-button
    :href="
      route(props.artist.followed ? 'api.unfollow' : 'api.follow', {
        artist: props.artist,
      })
    "
    method="post"
    @refresh="reload"
    :color="props.artist.followed ? 'danger' : 'primary'"
    v-if="$page.props.auth.user"
  >
    {{ props.artist.followed ? "Followed" : "Follow" }}
  </ajax-button>
</template>
<script setup>
import AjaxButton from "../base/AjaxButton.vue";
const props = defineProps(["artist"]);
let emit = defineEmits(["refresh"]);

function reload(...args) {
  emit("refresh", ...args);
}
</script>
