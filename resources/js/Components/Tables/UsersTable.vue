<template>
  <AjaxTable
    :columns="columns"
    id-field="id"
    :api="api"
    ref="table_ref"
    :current-page="currentPage"
    :search="search"
  >
    <template #column-image="user">
      <img :src="user.profile_photo_url" class="rounded" width="35" />
    </template>
    <template #column-actions="user">
      <div class="flex gap-1">
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
          :href="user.grow_url"
          v-if="user.grow_url"
          method="put"
          @refresh="reloadTable"
        >
          Grow
        </ajax-button>
      </div>
    </template>
    <template #column-everify="user">
      <template v-if="!user.email_verified_at">
        <i>Never!</i>
      </template>
      <template v-else>{{ formatDate(user.email_verified_at) }}</template>
    </template>
  </AjaxTable>

  <form-button
    class="btn btn-primary d-block sm:mt-4 mt-6"
    @click="reloadTable"
  >
    Reload
  </form-button>
</template>

<script setup>
import { ref } from "vue";
import { formatDate } from "../../helpers.js";
import AjaxButton from "../base/AjaxButton.vue";
import AjaxTable from "../base/Table/AjaxTable.vue";
import FormButton from "../base/Forms/FormButton.vue";

const table_ref = ref(null);

defineProps({
  api: {
    type: String,
    default: route("api.users"),
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
  image: "Profile Photo",
  name: "Full Name",
  email: "Email",
  role_name: "Role",
  everify: "Verify At",
  followings_count: "Count of Followings",
  created_at: "Created At",
  updated_at: "Updated At",
  actions: "Actions",
};

function reloadTable() {
  table_ref.value.reload();
}
</script>
