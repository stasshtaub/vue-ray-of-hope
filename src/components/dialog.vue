<template>
  <div class="dialog frame">
    <messages-list :messages="messages"></messages-list>
    <message-box @send="sendMessage"></message-box>
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
    messageBox: () => import("./messageBox")
  },
  data: () => ({
    messages: [],
    conn: null
  }),
  computed: {
    ...mapGetters(["PROFILE", "UNREAD"])
  },
  methods: {
    ...mapActions(["SEND_WS_DATA"]),
    getMessages() {
      axios
        .get("/api/dialogs/" + this.fromId)
        .then(resp => {
          this.messages = resp.data.messages;
        })
        .catch(err => {
          console.log(err);
        });
    },
    sendMessage(text) {
      this.messages.push({
        fromUser: this.PROFILE.id,
        toUser: this.$route.params.fromId,
        text: text,
        unread: true
      });

      let data = {
        command: "message",
        fromId: this.PROFILE.id,
        toId: this.$route.params.fromId,
        msg: text
      };
      this.SEND_WS_DATA(data);
    }
  },
  mounted() {
    this.getMessages();
  },
  watch: {
    UNREAD() {
      const mess = this.UNREAD[this.UNREAD.length - 1];
      if (mess.from.id == this.$route.params.fromId) {
        this.messages.push({
          fromUser: mess.from.id,
          toUser: mess.to.id,
          text: mess.text,
          unread: false
        });
      }
    }
  }
};
</script>

<style>
.dialog {
  width: 500px;
  margin: 0 auto;
}
</style>