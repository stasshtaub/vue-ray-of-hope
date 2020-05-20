<template>
  <div class="dialogs-list-item frame">
    <router-link :to="'/messages/'+dialog.id">
      <avatar :img="dialog.interlocutor.avatar" />
      <div class="info">
        <p class="name">{{dialog.interlocutor.name}}</p>
      </div>
    </router-link>
  </div>
</template>

<script>
export default {
  name: "dialogs-list-item",
  props: {
    dialog: {
      type: Object,
      default: () => ({
        id: null,
        unread: null,
        interlocutor: {}
      })
    }
  },
  components: {
    avatar: () => import("./avatar")
  }
};
</script>

<style>
.dialogs-list-item > * {
  display: flex;
  align-items: center;
  padding: 20px 30px;
}

.dialogs-list-item .info {
  margin-left: 10px;
}
</style>