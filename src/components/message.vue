<template>
  <div class="message">{{message.text}}</div>
</template>

<script>
export default {
  name: "message",
  props: {
    message: {
      type: Object,
      deault: {
        text: "",
        unread: true
      }
    }
  }
};
</script>

<style>
</style>