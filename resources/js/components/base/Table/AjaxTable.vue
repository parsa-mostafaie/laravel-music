<template>
  <div>
    <label for="search">Search</label>
    <input
      type="search"
      id="search"
      v-model="search"
      @input="searchChanges"
      class="form-control"
    />
  </div>
  <hr />
  <div class="main">
    <table-component
      :columns="props.columns"
      :id-field="props.idField"
      :rows="rows"
      v-if="(state == 1 || props.dontClear) && state >= 0 && !error"
    >
      <template v-for="(, slot) in $slots" #[slot]="bindings">
        <slot :name="slot" v-bind="bindings" />
      </template>
    </table-component>
    <slot name="fallback" v-if="!state">
      <div class="overlay mb-2">
        <div
          class="d-flex justify-content-center bg-white border-1 border border-gray p-2 align-items-center"
        >
          <div class="spinner-border" role="status"></div>
          <span class="ms-1">Loading...</span>
        </div>
      </div>
    </slot>
  </div>

  <pagination-component
    :page="page"
    @paginate="setpage"
    v-if="state == 1"
    :max-page="data.last_page"
    :from="data.from"
    :to="data.to"
    :total="data.total"
  />

  <slot name="error" v-bind="error" v-if="state < 0">
    <p class="text-danger">Error!</p>
  </slot>
</template>

<script setup>
import axios from "axios";
import { computed, onMounted, ref } from "vue";
import { debounce } from "../../../helpers";
import { error as error_alert } from "../../../alerts";

const props = defineProps({
  columns: {
    type: Object,
    required: true,
  },
  idField: {
    type: String,
    default: "id",
  },
  api: {
    type: String,
    required: true,
  },
  dontClear: {
    type: Boolean,
    default: true,
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

const data = ref({});
const rows = computed(() => data.value.data ?? []);
const state = ref(0); // 0: not loaded, 1: loaded, -1: error
const error = ref(null);
const page = ref(Number(props.currentPage));
const search = ref(props.search);

async function reload() {
  state.value = 0;
  try {
    const response = await axios.get(props.api, {
      params: { page: page.value, search: search.value },
    });
    data.value = response.data;
    error.value = null;
    state.value = 1;
    page.value = data.value.current_page;
  } catch (_error) {
    error.value = _error;
    state.value = -1;
    error_alert();
  }
}

function setpage(page_value) {
  page.value = page_value;
  reload();
  return false;
}

const searchChanges = debounce(function () {
  setpage(1);
  reload();
});

onMounted(reload);

defineExpose({
  reload,
});
</script>

<style scoped>
.main {
  position: relative;
}

.overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.overlay > div {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 5px;
}
</style>
