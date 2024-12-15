<template>
  <div class="flex flex-col lg:flex-row mt-2 justify-between items-center text-black dark:text-[#eee] overflow-x-auto">
    <span v-if="from && to" class="my-auto">
      Showing <b class="text-[blue] dark:text-[lightblue]">{{ from }}</b> to
      <b class="text-[blue] dark:text-[lightblue]">{{ to }}</b> of
      <b class="text-[blue] dark:text-[lightblue]">{{ total }}</b>
      entries
    </span>
    <p class="my-auto" v-else>No result Found!</p>

    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm sm:m-0 mt-2" aria-label="Pagination">
      <a
        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 hover:text-gray-600 ring-1 ring-inset ring-gray-300 hover:bg-gray-300 focus:z-20 focus:outline-offset-0"
        role="button"
        v-if="page > 1"
        @click="paginate(page - 1)"
      >
        <span>Previous</span>
      </a>

      <template v-for="(page_index, index) in displayedPages" :key="index">
        <a
          role="button"
          v-if="typeof page_index === 'number'"
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
        >{{ page_index }}</a>

        <!-- Show ellipsis with border -->
        <span v-if="isEllipsis(index)" class="relative inline-flex items-center px-4 py-2 border border-gray-300">...</span>
      </template>

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

// Function to determine which pages to display
const displayedPages = computed(() => {
  const pages = [];

  if (maxPage <= 5) {
    // If there are less than or equal to 5 pages, show all
    for (let i = 1; i <= maxPage; i++) {
      pages.push(i);
    }
  } else {
    // Always show the first and last pages
    pages.push(1);

    // Calculate start and end for middle pages
    let start = Math.max(2, page.value - 1);
    let end = Math.min(maxPage - 1, page.value + 1);

    // Adjust start and end based on current page position
    if (page.value <= 3) {
      end = Math.min(4, maxPage - 1); // Show more pages if near the start
    } else if (page.value >= maxPage - 2) {
      start = Math.max(maxPage - 3, 2); // Show more pages if near the end
    }

    for (let i = start; i <= end; i++) {
      pages.push(i);
    }

    // Add ellipsis if necessary
    if (start > 2) {
      pages.splice(1, 0, '...'); // Add ellipsis after the first page
    }

    if (end < maxPage - 1) {
      pages.push('...'); // Add ellipsis before the last page
    }

    pages.push(maxPage);
    
    // Remove duplicate ellipses if they appear consecutively
    const uniquePages = [];
    for (let i = 0; i < pages.length; i++) {
      if (pages[i] !== '...' || (pages[i] === '...' && uniquePages[uniquePages.length - 1] !== '...')) {
        uniquePages.push(pages[i]);
      }
    }
    
    return uniquePages;
  }

  return pages;
});

// Function to check if the current index should display ellipsis
const isEllipsis = (index) => displayedPages.value[index] === '...';

const paginate = ($page) => {
  emit("paginate", $page);
};
</script>

<style scoped>
/* Responsive styles */
@media (max-width: 640px) {
   nav {
     flex-wrap: nowrap; /* Prevent wrapping */
     overflow-x: auto; /* Allow horizontal scrolling */
   }
   .pagination-container { /* Ensure container allows scrolling */
     min-width: calc(100vw - 40px); /* Adjust for padding/margins */
   }
}

/* Ensure pagination buttons are not too small */
nav a {
   min-width: fit-content; /* Ensure buttons have enough width */
}
</style>
