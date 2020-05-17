<template>
  <div class="dialog frame">
      <messages-list :pushed="pushed" :messages="messages" />
    <message-box @send="sendMessage" />
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import axios from "axios";

export default {
  name: "dialog",
  props: ["fromId"],
  components: {
    messagesList: () => import("./messagesList"),
    messageBox: () => import("./messageBox"),
  },
  data: () => ({
    messages: [],
    conn: null,
    pushed: false,
  }),
  computed: {
    ...mapGetters(["PROFILE", "UNREAD"]),
  },
  methods: {
    ...mapActions(["SEND_WS_DATA"]),
    getMessages() {
      axios
        .get("/api/dialogs/" + this.fromId)
        .then((resp) => {
          this.messages = resp.data.messages;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    sendMessage(text) {
      this.pushed = true;
      this.messages.push({
        fromUser: this.PROFILE.id,
        toUser: this.$route.params.fromId,
        text: text,
        unread: true,
      });

      let data = {
        command: "message",
        fromId: this.PROFILE.id,
        toId: this.$route.params.fromId,
        msg: text,
      };
      this.SEND_WS_DATA(data);
    },
  },
  mounted() {
    this.getMessages();
    this.$root.$on("message", (mess) => {
      this.pushed = true;
      this.messages.push({
        fromUser: mess.from.id,
        toUser: mess.to.id,
        text: mess.text,
        unread: false,
      });
    });
  },
};
</script>

<style>
.dialog {
  width: 500px;
  margin: 0 auto;
  height: 100%;
  display: grid;
  grid-template-rows: 1fr 55px;
  overflow: hidden;
}
</style>
