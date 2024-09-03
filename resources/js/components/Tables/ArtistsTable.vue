<template>
  <!-- Modal -->
  <add-artist @refresh="reloadTable" />

  <AjaxTable
    :columns="columns"
    id-field="id"
    :api="api"
    ref="table_ref"
    :current-page="currentPage"
    :search="search"
  >
    <template #column-createdAt="artist">
      {{ formatDate(artist.created_at) }}
    </template>
    <template #column-actions="artist">
      <ajax-button
        danger
        :href="artist.destroy_url"
        method="delete"
        @refresh="reloadTable"
      >
        Delete
      </ajax-button>
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
  createdAt: "Created At",
  actions: "Actions",
};

function reloadTable() {
  table_ref.value.reload();
}
</script>
