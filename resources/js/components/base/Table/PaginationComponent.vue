<template>
  <div
    class="flex mt-2 justify-between items-center text-black dark:text-[#eee] sm:flex-row flex-col"
  >
    <span v-if="from && to" class="my-auto">
      Showing <span class="text-[blue]">{{ from }}</span> to
      <span class="text-[blue]">{{ to }}</span> of
      <span class="dark:text-[lightblue] text-[darkblue]">{{ total }}</span>
      entries
    </span>
    <p class="my-auto" v-else>No result Found!</p>

    <nav
      class="isolate inline-flex -space-x-px rounded-md shadow-sm sm:m-0 mt-2"
      aria-label="Pagination"
    >
      <a
        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 hover:text-gray-600 ring-1 ring-inset ring-gray-300 hover:bg-gray-300 focus:z-20 focus:outline-offset-0"
        role="button"
        v-if="page > 1"
        @click="paginate(page - 1)"
      >
        <span>Previous</span>
      </a>

      <a
        role="button"
        v-for="page_index in maxPage"
        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold"
        :class="{
          'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600':
            page_index == page,
          'text-gray-900 ring-1 dark:bg-white dark:hover:bg-gray-900 dark:hover:text-gray-400 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0 hover:ring-gray-900':
            page_index != page,
          'rounded-s': page == page_index && page == 1,
          'rounded-e': page == page_index && page == maxPage,
        }"
        @click="paginate(page_index)"
        >{{ page_index }}</a
      >

      <a
        v-if="page < maxPage"
        role="button"
        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 hover:text-gray-600 ring-1 ring-inset ring-gray-300 hover:bg-gray-300 focus:z-20 focus:outline-offset-0"
        @click="paginate(page + 1)"
      >
        <span>Next</span>
      </a>
    </nav>
  </div>
</template>
<script setup>
import { computed } from "vue";

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
const page = computed(() => Math.min(maxPage, props.page));

const paginate = ($page) => {
  emit("paginate", $page);
};
</script>
