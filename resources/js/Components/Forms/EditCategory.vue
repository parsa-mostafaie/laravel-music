<template>
  <DialogModal
    class="fade"
    :show="modalShown"
    id="editCategoryModal"
    @close="close"
  >
    <template #title>
      <div class="flex justify-between">
        <h5 id="editCategoryModalLabel">Edit Category</h5>
      </div>
    </template>
    <template #content>
      <ajax-form
        @success="onSuccess"
        @reset="reset"
        v-slot="states"
        :action="form_url"
        method="put"
      >
        <input-label>Name</input-label>
        <form-control v-bind="states" name="name" v-model="name" />

        <input-label class="mt-2">Parent Category</input-label>
        <categories-select
          :states="states"
          v-model="parent_id"
          :excludes="[category_id]"
        />

        <div class="flex gap-1 mt-4">
          <form-button v-bind="states" type="submit" />
          <form-button variant="danger" type="button" @click="close">
            Close
          </form-button>
        </div>
      </ajax-form>
    </template>
  </DialogModal>
</template>

<script setup>
import { computed, ref } from "vue";
import AjaxForm from "../base/Forms/AjaxForm.vue";
import FormControl from "../base/Forms/FormControl.vue";
import FormButton from "../base/Forms/FormButton.vue";
import DialogModal from "../DialogModal.vue";
import InputLabel from "@/Components/base/Forms/InputLabel.vue";
import CategoriesSelect from "../Selects/CategoriesSelect.vue";

const emit = defineEmits(["refresh"]);

const category_id = ref("");
const name = ref("");
const parent_id = ref("");

const modalShown = ref(false);

const form_url = computed(() => `/api/categories/${category_id.value}`);

function onSuccess() {
  close();
  emit("refresh");
}

function reset() {
  fill({}, false);
}

function fill(data = {}, _ = true) {
  _ && show();
  name.value = data.name ?? "";
  category_id.value = data.id ?? "";
  parent_id.value = data.parent_id ?? "";
}

function show() {
  modalShown.value = true;
}

function close() {
  modalShown.value = false;
}

defineExpose({
  fill,
  show,
  close,
});
</script>
