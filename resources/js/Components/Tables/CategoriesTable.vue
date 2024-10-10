<template>
  <!-- Modal -->
  <add-category @refresh="reloadTable" ref="add_ref" />
  <edit-category @refresh="reloadTable" ref="edit_ref" />

  <AjaxTable
    :columns="columns"
    id-field="id"
    :api="api"
    ref="table_ref"
    :current-page="currentPage"
    :search="search"
  >
    <template #column-parent="{ parent }">
      <template v-if="parent">
        <Link :href="parent.url" class="text-[lightblue]">{{ parent.name }}</Link>
        {{ ' - ' }}
        <b>{{ parent.id }}</b>
      </template>
      <pre v-else>Independent</pre>
    </template>
    <template #column-createdAt="category">
      {{ formatDate(category.created_at) }}
    </template>
    <template #column-actions="category">
      <div class="flex gap-1">
        <ajax-button
          danger
          :href="category.destroy_url"
          method="delete"
          variant="danger"
          @refresh="reloadTable"
        >
          Delete
        </ajax-button>
        <form-button
          variant="secondary"
          @click="fillEdit(category)"
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
import AddCategory from "../Forms/AddCategory.vue";
import EditCategory from "../Forms/EditCategory.vue";
import FormButton from "../base/Forms/FormButton.vue";
import { Link } from "@inertiajs/vue3";

const table_ref = ref(null);
const edit_ref = ref(null);
const add_ref = ref(null);

const { api, currentPage, search } = defineProps({
  api: {
    type: String,
    default: route('api.categories'),
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
  parent: "Parent",
  tracks_count: "Count of tracks",
  createdAt: "Created At",
  actions: "Actions",
};

function reloadTable() {
  table_ref.value.reload();
}

function fillEdit(category) {
  edit_ref.value.fill(category);
}
</script>
