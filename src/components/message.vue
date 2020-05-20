<template>
  <div class="message" :class="isSelf ? 'self' : 'foreign'">{{ message.text }}</div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "message",
  props: {
    message: {
      type: Object,
      deault: {
        fromUser: null,
        toUser: null,
        text: "",
        unread: true
      }
    }
  },
  computed: {
    ...mapGetters(["PROFILE"]),
    isSelf() {
      return this.message.fromUser == this.PROFILE.id;
    }
  }
};
</script>

<style>
.message {
  word-break: break-word;
  width: fit-content;
  max-width: 80%;
  padding: 10px 10px;
  border-radius: 12px;
  color: #fff;
}
.message.self {
  margin-left: auto;
  background-color: #007bf5;
}
.message.foreign {
  background-color: #f5f3f3;
  color: #505050;
}
</style>
