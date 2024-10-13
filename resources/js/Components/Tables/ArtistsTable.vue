<template>
  <!-- Modal -->
  <add-artist @refresh="reloadTable" ref="add_ref" />
  <edit-artist @refresh="reloadTable" ref="edit_ref" />

  <AjaxTable
    :columns="columns"
    id-field="id"
    :api="api"
    ref="table_ref"
    :current-page="currentPage"
    :search="search"
  >
    <template #column-id="artist">
      <a :href="artist.profile_url">{{ artist.id }}</a>
    </template>
    <template #column-bio="artist">
      <p style="max-width: 150px" :title="artist.bio" class="text-truncate">
        {{ artist.bio }}
      </p>
    </template>
    <template #column-image="artist">
      <img :src="artist.image_url" width="30" v-if="artist.image_url" />
      <pre v-else>No Image Found</pre>
    </template>
    <template #column-createdAt="artist">
      {{ formatDate(artist.created_at) }}
    </template>
    <template #column-actions="artist">
      <div class="flex gap-1">
        <ajax-button
          danger
          :href="artist.destroy_url"
          method="delete"
          variant="danger"
          @refresh="reloadTable"
        >
          Delete
        </ajax-button>
        <form-button
          variant="secondary"
          @click="fillEdit(artist)"
        >
          Edit
        </form-button>
      </div>
    </template>
  </AjaxTable>

  <div class="flex gap-1 sm:mt-2 mt-4">
    <form-button variant="primary" @click="reloadTable">Reload</form-button>

    <!-- Button trigger modal -->
    <form-button variant="secondary" @click="add_ref.show()"> Add </form-button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { formatDate } from "../../helpers.js";
import AjaxTable from "../base/Table/AjaxTable.vue";
import AjaxButton from "../base/AjaxButton.vue";
import AddArtist from "../Forms/AddArtist.vue";
import EditArtist from "../Forms/EditArtist.vue";
import FormButton from "../base/Forms/FormButton.vue";

const table_ref = ref(null);
const edit_ref = ref(null);
const add_ref = ref(null);

const { api, currentPage, search } = defineProps({
  api: {
    type: String,
    default: route('api.artists'),
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
  bio: "Bio",
  image: "Image",
  tracks_count: "Count of tracks",
  followers_count: "Count of followers",
  createdAt: "Created At",
  actions: "Actions",
};

function reloadTable() {
  table_ref.value.reload();
}

function fillEdit(artist) {
  edit_ref.value.fill(artist);
}
</script>
