<template>
  <div
    class="modal fade"
    id="addArtistModal"
    tabindex="-1"
    aria-labelledby="addArtistModal"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Artist</h5>
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
            v-slot="states"
            action="/api/artist"
            method="post"
          >
            <div class="input-group">
              <span class="input-group-text">Name</span>
              <form-control v-bind="states" name="name" />
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
import { ref } from "vue";

const emit = defineEmits(["refresh"]);
const closeRef = ref(null);

function onSuccess() {
  closeRef.value.click();
  emit("refresh");
}
</script>
