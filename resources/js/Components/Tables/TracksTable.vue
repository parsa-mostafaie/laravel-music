<template>
  <AjaxTable
    :columns="columns"
    id-field="id"
    :api="api"
    ref="table_ref"
    :current-page="currentPage"
    :search="search"
  >
    <template #column-id="track">
      <a href="#">{{ track.id }}</a>
    </template>
  </AjaxTable>

  <div class="flex gap-1 sm:mt-2 mt-4">
    <form-button variant="primary" @click="reloadTable">Reload</form-button>

    <!-- Button trigger modal -->
    <form-button variant="secondary" @click="add_ref?.show()"> Add </form-button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { formatDate } from "../../helpers.js";
import AjaxTable from "../base/Table/AjaxTable.vue";
import AjaxButton from "../base/AjaxButton.vue";
import FormButton from "../base/Forms/FormButton.vue";

const table_ref = ref(null);
const edit_ref = ref(null);
const add_ref = ref(null);

const { api, currentPage, search } = defineProps({
  api: {
    type: String,
    default: route('api.tracks'),
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
</script>
