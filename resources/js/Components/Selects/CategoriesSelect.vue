<template>
  <form-select
    :name="name || 'parent_id'"
    :options="except( $page.props.categories_select, excludes )"
    v-bind="states"
  >
    <option value v-if="!required">--Independent--</option>
  </form-select>
</template>
<script setup>
import FormSelect from "@/Components/base/Forms/FormSelect.vue";
import { except } from "@/helpers";

const props = defineProps({
  name: {},
  states: { type: Object },
  excludes: { default: [] },
  required: { type: Boolean, default: false },
});
</script>
