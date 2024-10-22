<template>
  <div
    class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex justify-start p-3"
  >
    <slot name="image" />
    <div class="p-5 grow">
      <div
        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
        v-if="$slots.header"
      >
        <slot name="header" />
      </div>
      <div
        class="font-normal text-gray-700 dark:text-gray-400"
        v-if="$slots.default"
      >
        <slot />
      </div>
      <div class="px-6 pt-4 pb-2" v-if="$slots.footer">
        <slot name="footer" />
      </div>
    </div>
  </div>
</template>
