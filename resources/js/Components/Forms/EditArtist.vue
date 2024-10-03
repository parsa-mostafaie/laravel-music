<template>
  <DialogModal
    class="fade"
    :show="modalShown"
    id="editArtistModal"
    @close="close"
  >
    <template #title>
      <div class="flex justify-between">
        <h5 id="editArtistModalLabel">Add Artist</h5>
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

        <input-label class="mt-3">Bio</input-label>
        <form-text-area v-bind="states" name="bio" v-model="bio" />

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
import { computed, ref } from "vue";
import AjaxForm from "../base/Forms/AjaxForm.vue";
import FormControl from "../base/Forms/FormControl.vue";
import FormTextArea from "../base/Forms/FormTextArea.vue";
import FormButton from "../base/Forms/FormButton.vue";
import DialogModal from "../DialogModal.vue";
import InputLabel from "@/Components/base/Forms/InputLabel.vue";
import FormUpload from "../base/Forms/FormUpload.vue";

const emit = defineEmits(["refresh"]);

const artist_id = ref("");
const name = ref("");
const fileModel = ref("");
const bio = ref("");

const modalShown = ref(false);

const form_url = computed(() => route('api.artists.update', [artist_id.value]));

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
  artist_id.value = data.id ?? "";
  bio.value = data.bio ?? "";
  fileModel.value = "";
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
