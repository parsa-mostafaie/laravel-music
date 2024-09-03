<template>
  <div class="d-flex mt-1 justify-content-between align-items-center">
    <div v-if="from && to">
      Showing {{ from }} to {{ to }} of {{ total }} entries
    </div>
    <div v-else>No result Found!</div>

    <ul class="pagination m-0">
      <li class="page-item previous" v-if="page > 1">
        <a
          role="button"
          tabindex="-1"
          class="page-link"
          @click="paginate(page - 1)"
          >Previous
        </a>
      </li>
      <li
        v-for="page_index in maxPage"
        :class="{ 'page-item': true, active: page_index == page }"
      >
        <a
          role="button"
          aria-current="page"
          tabindex="0"
          class="page-link"
          @click="paginate(page_index)"
          >{{ page_index }}</a
        >
      </li>
      <li class="page-item next" v-if="page < maxPage">
        <a
          role="button"
          tabindex="-1"
          class="page-link"
          @click="paginate(page + 1)"
          >Next</a
        >
      </li>
    </ul>
  </div>
</template>
<script setup>
const emit = defineEmits(["paginate"]);

const props = defineProps({
  page: {
    type: Number,
    default: 1,
  },
  maxPage: {
    type: Number,
    default: 1,
  },
  from: {
    type: Number,
    default: 1,
  },
  to: {
    type: Number,
    default: 1,
  },
  total: {
    type: Number,
    default: 1,
  },
});
const { maxPage, from, to, total } = props;
const page = Math.min(maxPage, props.page);

const paginate = ($page) => {
  emit("paginate", $page);
};
</script>
