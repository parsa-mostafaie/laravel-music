<template>
  <div class="flex flex-col mb-3">
    <div class="overflow-x-auto">
      <div class="min-w-full inline-block align-middle">
        <div class="overflow-x-auto">
          <table
            class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700"
          >
            <thead>
              <tr class="bg-neutral-300">
                <th
                  v-for="column in props.columns"
                  scope="col"
                  class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                >
                  {{ column }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="row in props.rows"
                :key="row[props.idField]"
                class="odd:bg-white even:bg-gray-100 hover:bg-gray-100 dark:odd:bg-neutral-800 dark:even:bg-neutral-700 dark:hover:bg-neutral-700"
              >
                <td
                  v-for="(, key) in props.columns"
                  :key="key"
                  class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                >
                  <div class="overflow-x-auto">
                    <slot :name="`column-${key}`" v-bind="row">{{
                      row[key]
                    }}</slot>
                  </div>
                </td>
              </tr>
              <tr
                class="bg-white hover:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700"
                v-if="!props.rows.length"
              >
                <td
                  :colspan="Object.keys(props.columns).length"
                  class="text-center px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                >
                  No Result Found!
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  columns: {
    type: Object,
    required: true,
  },
  rows: {
    type: Array,
    required: true,
  },
  idField: {
    type: String,
    default: "id",
  },
});
</script>

<style scoped>
td,
tr,
th {
  vertical-align: text-center;
}
</style>
