<template>
  <div class="dialogs-list-item frame">
    <router-link :to="'/messages/'+dialog.fromUser">{{"Диалог с "+dialog.fromUser}}</router-link>
  </div>
</template>

<script>
export default {
  name: "dialogs-list-item",
  props: {
    dialog: {
      type: Object,
      default: () => ({
        fromUser: null,
        text: null,
        unread: null
      })
    }
  }
};
</script>

<style>
</style>