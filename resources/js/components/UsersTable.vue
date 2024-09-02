<template>
  <AjaxTable
    :columns="columns"
    id-field="id"
    :api="api"
    ref="table_ref"
    :current-page="currentPage"
    :search="search"
  >
    <template #column-actions="user">
      <ajax-button
        method="put"
        :href="user.shrink_url"
        v-if="user.shrink_url"
        color="danger"
        @refresh="reloadTable"
      >
        Shrink
      </ajax-button>
      <ajax-button
        class="ms-1"
        :href="user.grow_url"
        v-if="user.grow_url"
        method="put"
        @refresh="reloadTable"
      >
        Grow
      </ajax-button>
    </template>
    <template #column-everify="user">
      <template v-if="!user.email_verified_at">
        <i>Never!</i>
      </template>
      <template v-else>{{ formatDate(user.email_verified_at) }}</template>
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
    default: "/api/users",
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
  name: "Full Name",
  email: "Email",
  role_name: "Role",
  everify: "Verified At",
  created_at: "Created At",
  updated_at: "Updated At",
  actions: "Actions",
};

function reloadTable() {
  table_ref.value.reload();
}
</script>
