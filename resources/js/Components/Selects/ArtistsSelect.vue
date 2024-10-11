<template>
  <form-select
    :name="name || 'artist_id'"
    :options="except($page.props.artists_select, excludes)"
    v-bind="states"
  >
  </form-select>
</template>
<script setup>
import FormSelect from "@/Components/base/Forms/FormSelect.vue";
import { except } from "@/helpers";

const props = defineProps({
  name: {},
  states: { type: Object },
  excludes: { default: [] },
});
</script>
