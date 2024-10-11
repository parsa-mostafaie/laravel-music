<template>
  <div class="fixed bottom-4 left-4 dark:bg-gray-950 rounded-lg">
    <button
      @click="toggleTheme"
      @contextmenu.prevent="themeFromSystem"
      class="h-12 w-12 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
    >
      <svg
        class="fill-violet-700 block dark:hidden"
        fill="currentColor"
        viewBox="0 0 20 20"
      >
        <path
          d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
        ></path>
      </svg>
      <svg
        class="fill-yellow-500 hidden dark:block"
        fill="currentColor"
        viewBox="0 0 20 20"
      >
        <path
          d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
          fill-rule="evenodd"
          clip-rule="evenodd"
        ></path>
      </svg>
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";

const theme = ref(window.localStorage.theme || defaultTheme());

function defaultTheme() {
  return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
}

function applyTheme() {
    if (theme.value === "dark") {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
}

// Watch for changes in the theme ref and apply the theme
watch(theme, (newTheme) => {
    window.localStorage.theme = newTheme;
    applyTheme();
});

// Toggle between light and dark themes
function toggleTheme() {
    theme.value = theme.value === "dark" ? "light" : "dark";
}

// Reset to system preference
function themeFromSystem() {
  theme.value = defaultTheme();
}

onMounted(() => applyTheme());
</script>
