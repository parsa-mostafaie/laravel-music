<template>
  <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped mb-0">
      <thead>
        <tr>
          <th v-for="column in props.columns" :key="column">{{ column }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in props.rows" :key="row[props.idField]">
          <td v-for="(, key) in props.columns" :key="key">
            <slot :name="`column-${key}`" v-bind="row">{{ row[key] }}</slot>
          </td>
        </tr>
        <tr
          v-if="!props.rows.length"
        >
          <td :colspan="Object.keys(props.columns).length" class="text-center">No Result Found!</td>
        </tr>
      </tbody>
    </table>
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
  vertical-align: text-top;
}
</style>
