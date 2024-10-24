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
        :action="route('api.categories.update', category)"
        method="put"
      >
        <input-label>Name</input-label>
        <form-control v-bind="states" name="name" v-model="category.name" />

        <input-label class="mt-2">Parent Category</input-label>
        <categories-select
          :states="states"
          v-model="category.parent_id"
          :excludes="[category.id]"
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
import { reactive, ref } from "vue";
import AjaxForm from "../base/Forms/AjaxForm.vue";
import FormControl from "../base/Forms/FormControl.vue";
import FormButton from "../base/Forms/FormButton.vue";
import DialogModal from "../DialogModal.vue";
import InputLabel from "@/Components/base/Forms/InputLabel.vue";
import CategoriesSelect from "../Selects/CategoriesSelect.vue";

const emit = defineEmits(["refresh"]);

const category = reactive({});

const modalShown = ref(false);

function onSuccess() {
  close();
  emit("refresh");
}

function reset() {
  fill({}, false);
}

function fill(data = {}, _ = true) {
  _ && show();
  Object.assign(category, data);
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
