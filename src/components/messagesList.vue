<template>
  <div class="messages-list">
    <message v-for="message in messages" :key="message.id" :message="message"></message>
  </div>
</template>

<script>
export default {
  name: "messages-list",
  components: {
    message: () => import("./message")
  },
  props: {
    messages: {
      type: Array,
      default: () => []
    }
  }
};
</script>

<style>
.messages-list {
  display: grid;
  grid-gap: 20px;
  padding: 20px;
}
</style>
