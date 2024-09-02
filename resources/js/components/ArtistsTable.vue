<template>
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
  </AjaxTable>

  <button class="btn btn-primary d-block mt-1" @click="reloadTable">
    Reload
  </button>
</template>

<script setup>
import { ref } from "vue";
import AjaxTable from "./AjaxTable.vue";
import AjaxButton from "./AjaxButton.vue";
import { formatDate } from "../helpers.js";

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
};

function reloadTable() {
  table_ref.value.reload();
}
</script>
