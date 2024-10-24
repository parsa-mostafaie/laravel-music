<template>
  <add-track ref="add_ref" @refresh="reloadTable" />
  <edit-track ref="edit_ref" @refresh="reloadTable" />

  <AjaxTable
    :columns="columns"
    id-field="id"
    :api="api"
    ref="table_ref"
    :current-page="currentPage"
    :search="search"
  >
    <template #column-id="track">
      <Link :href="route('tracks.listen', [track])">{{ track.id }}</Link>
    </template>

    <template #column-artist="track">
      <Link :href="track.artist.profile_url">{{ track.artist.name }}</Link>
    </template>

    <template #column-category="track">
      <a :href="track.category.url">{{ track.category.name }}</a>
    </template>

    <template #column-cover="track">
      <img :src="track.image_url" width="30" v-if="track.image_url" />
      <pre v-else>No Image Found</pre>
    </template>

    <template #column-published_at="track">
      <template v-if="!track.published_at">
        <i>Never!</i>
      </template>
      <template v-else>{{ formatDate(track.published_at) }}</template>
    </template>

    <template #column-actions="track">
      <AjaxButton
        class="mx-1"
        :variant="track.published_at ? 'danger' : 'primary'"
        :href="route('api.tracks.publish', track)"
        :danger="!!track.published_at"
        method="put"
        @refresh="reloadTable"
      >
        {{ track.published_at ? "Unpublish" : "Publish" }}
      </AjaxButton>

      <form-button variant="secondary" @click="fillEdit(track)">
        Edit
      </form-button>
    </template>

    <template #column-play="track">
      <template v-if="track.file_url">
        <audio controls class="h-10">
          <source :src="track.file_url" :type="track.file_mime" />
        </audio>
      </template>
    </template>
  </AjaxTable>

  <div class="flex gap-1 sm:mt-2 mt-4">
    <form-button variant="primary" @click="reloadTable">Reload</form-button>

    <!-- Button trigger modal -->
    <form-button variant="secondary" @click="add_ref?.show()">
      Add
    </form-button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { formatDate } from "../../helpers.js";
import AjaxTable from "../base/Table/AjaxTable.vue";
import AjaxButton from "../base/AjaxButton.vue";
import FormButton from "../base/Forms/FormButton.vue";
import AddTrack from "../Forms/AddTrack.vue";
import EditTrack from "../Forms/EditTrack.vue";
import CategoryChaining from "../CategoryChaining.vue";
import { Link } from "@inertiajs/vue3";

const table_ref = ref(null);
const edit_ref = ref(null);
const add_ref = ref(null);

defineProps({
  api: {
    type: String,
    default: route("api.tracks.index"),
  },
  currentPage: {
    type: [Number, String],
    default: 1,
  },
  search: {
    type: String,
    default: "",
  },
});

const columns = {
  id: "#",
  name: "Name",
  summary: "Summary",
  lyric: "Lyric",
  cover: "Cover Image",
  time_string: "Time",
  size: "Size",
  quality: "Quality",
  artist: "Artist",
  category: "Category",
  play: "Player",
  published_at: "Publish Date",
  created_at: "Creation Date",
  updated_at: "Latest Update Date",
  actions: "Actions",
};

function reloadTable() {
  table_ref.value.reload();
}

function fillEdit(track) {
  edit_ref.value.fill(track);
}
</script>
