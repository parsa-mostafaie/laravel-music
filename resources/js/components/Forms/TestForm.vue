<template>
  <ajax-form
    v-slot="states"
    action="/handle"
    method="put"
    class="d-flex gap-1 flex-column"
  >
    <form-control v-bind="states" name="text" />

    <form-button class="btn-primary" v-bind="states" type="submit" />
  </ajax-form>
</template>
