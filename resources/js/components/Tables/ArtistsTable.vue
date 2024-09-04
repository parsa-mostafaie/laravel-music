<template>
  <!-- Modal -->
  <add-artist @refresh="reloadTable" />
  <edit-artist @refresh="reloadTable" ref="edit_ref" />

  <AjaxTable
    :columns="columns"
    id-field="id"
    :api="api"
    ref="table_ref"
    :current-page="currentPage"
    :search="search"
  >
    <template #column-bio="artist">
      <p style="max-width: 150px" :title="artist.bio" class="text-truncate">
        {{ artist.bio }}
      </p>
    </template>
    <template #column-image="artist">
      <img :src="artist.image_url" width="30px" v-if="artist.image_url"/>
      <pre v-else>No Image Found</pre>
    </template>
    <template #column-createdAt="artist">
      {{ formatDate(artist.created_at) }}
    </template>
    <template #column-actions="artist">
      <div class="btn-group">
        <ajax-button
          danger
          :href="artist.destroy_url"
          method="delete"
          @refresh="reloadTable"
        >
          Delete
        </ajax-button>
        <button
          class="btn btn-secondary btn-sm"
          data-bs-toggle="modal"
          data-bs-target="#editArtistModal"
          @click="fillEdit(artist)"
        >
          Edit
        </button>
      </div>
    </template>
  </AjaxTable>

  <div class="btn-group mt-1">
    <button class="btn btn-primary" @click="reloadTable">Reload</button>

    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn btn-info"
      data-bs-toggle="modal"
      data-bs-target="#addArtistModal"
    >
      Add
    </button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { formatDate } from "../../helpers.js";

const table_ref = ref(null);
const edit_ref = ref(null);

const { api, currentPage, search } = defineProps({
  api: {
    type: String,
    default: "/api/artists",
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
