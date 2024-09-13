<template>
  <DialogModal
    class="fade"
    :show="modalShown"
    id="addArtistModal"
    @close="close"
  >
    <template #title>
      <div class="flex justify-between">
        <h5 id="addArtistModalLabel">Add Artist</h5>
      </div>
    </template>
    <template #content>
      <ajax-form
        @success="onSuccess"
        @reset="(event) => event.reset()"
        v-slot="states"
        action="/api/artists"
        method="post"
      >
        <input-label>Name</input-label>
        <form-control v-bind="states" name="name" />

        <input-label class="mt-3">Bio</input-label>
        <form-text-area v-bind="states" name="bio" />

        <input-label class="my-2">Image</input-label>
        <form-upload v-bind="states" name="image" type="file" />

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
import { ref } from "vue";
import AjaxForm from "../base/Forms/AjaxForm.vue";
import FormControl from "../base/Forms/FormControl.vue";
import FormTextArea from "../base/Forms/FormTextArea.vue";
import FormButton from "../base/Forms/FormButton.vue";
import DialogModal from "../DialogModal.vue";
import InputLabel from "@/Components/base/Forms/InputLabel.vue";
import FormUpload from '../base/Forms/FormUpload.vue';

const emit = defineEmits(["refresh"]);
const modalShown = ref(false);

function onSuccess() {
  close();
  emit("refresh");
}

function show() {
  modalShown.value = true;
}

function close() {
  modalShown.value = false;
}

defineExpose({ show, close });
</script>
