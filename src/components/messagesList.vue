<template>
  <div class="messages-list">
    <message
      v-for="message in messages"
      :key="message.id"
      :message="message"
    ></message>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "messages-list",
  components: {
    message: () => import("./message"),
  },
  props: {
    fromId: {
      type: Int8Array,
      default: null,
    },
  },
  data: () => ({
    messages: [],
  }),
  methods: {
    getDialog() {
      axios
        .get("/api/dialogs/" + this.fromId)
        .then((resp) => {
          this.dialogs = resp.data.dialogs;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style>
.messages-list {
  display: grid;
  grid-gap: 20px;
}
</style>
