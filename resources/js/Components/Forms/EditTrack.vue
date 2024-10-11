<template>
  <DialogModal
    class="fade"
    :show="modalShown"
    id="editTrackModal"
    @close="close"
  >
    <template #title>
      <div class="flex justify-between">
        <h5 id="editTrackModalLabel">Edit Track</h5>
      </div>
    </template>
    <template #content>
      <ajax-form
        @success="onSuccess"
        @reset="reset"
        v-slot="states"
        :action="route('api.tracks.update', track)"
        method="put"
      >
        <input-label>Name</input-label>
        <form-control v-bind="states" name="name" v-model="track.name"/>

        <input-label class="mt-3">Summary</input-label>
        <form-text-area v-bind="states" name="summary" v-model="track.summary"/>

        <input-label class="mt-3">Lyric</input-label>
        <form-text-area v-bind="states" name="lyric" v-model="track.lyric"/>

        <input-label class="my-2">Image</input-label>
        <form-upload v-bind="states" name="cover" type="file" />

        <input-label class="my-2">File</input-label>
        <form-upload v-bind="states" name="file" type="file" />

        <input-label class="mt-3">Quality</input-label>
        <form-control v-bind="states" name="quality" v-model="track.quality"/>

        <input-label class="mt-3">Category</input-label>
        <categories-select name="category_id" v-bind="states" required v-model="track.category_id"/>

        <input-label class="mt-3">Artist</input-label>
        <artists-select name="artist_id" v-bind="states" required v-model="track.artist_id"/>

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
import FormTextArea from "../base/Forms/FormTextArea.vue";
import FormButton from "../base/Forms/FormButton.vue";
import DialogModal from "../DialogModal.vue";
import InputLabel from "@/Components/base/Forms/InputLabel.vue";
import FormUpload from "../base/Forms/FormUpload.vue";
import CategoriesSelect from "../Selects/CategoriesSelect.vue";
import ArtistsSelect from "../Selects/ArtistsSelect.vue";

const emit = defineEmits(["refresh"]);

const track = reactive({});

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
  Object.assign(track, data);
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
