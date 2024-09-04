<template>
  <div
    class="modal fade"
    id="editArtistModal"
    tabindex="-1"
    aria-labelledby="editArtistModal"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Artist</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <ajax-form
            @success="onSuccess"
            @reset="reset"
            v-slot="states"
            :action="form_url"
            method="put"
          >
            <div class="input-group">
              <span class="input-group-text">Name</span>
              <form-control v-bind="states" name="name" v-model="name" />
            </div>

            <div class="btn-group mt-2 btn-group">
              <form-button class="btn-primary" v-bind="states" type="submit" />
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                ref="closeRef"
              >
                Close
              </button>
            </div>
          </ajax-form>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed, ref } from "vue";

const emit = defineEmits(["refresh"]);
const closeRef = ref(null);

const artist_id = ref('');
const name = ref('');

const form_url = computed(() => `/api/artists/${artist_id.value}`);

function onSuccess() {
  closeRef.value.click();
  emit("refresh");
}

function reset() {
  fill({ name: '', id: '' });
}

function fill(data) {
  name.value = data.name;
  artist_id.value = data.id;
  console.log(data, name.value, artist_id.value);
}

defineExpose({
  fill,
});
</script>
