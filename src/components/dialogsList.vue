<template>
  <div class="dialogs-list">
    <dialogs-list-item v-for="dialog in dialogs" :key="dialog.userFrom" :dialog="dialog"></dialogs-list-item>
  </div>
</template>

<script>
export default {
  name: "dialogs-list",
  components: {
    dialogsListItem: () => import("./dialogsListItem")
  },
  props: {
    dialogs: {
      default: []
    }
  }
};
</script>

<style >
.dialogs-list {
  display: grid;
  grid-gap: 20px;
  width: 500px;
  margin: 0 auto;
}
</style>
