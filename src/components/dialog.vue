<template>
  <div class="dialog frame">
    <messages-list :messages="messages"></messages-list>
    <message-box @send="sendMessage"></message-box>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
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
    ...mapGetters(["PROFILE"])
  },
  methods: {
    getMessages() {
      axios
        .get("/api/dialog/", {
          params: {
            fromId: this.fromId
          }
        })
        .then(resp => {
          this.messages = resp.data.messages;
        })
        .catch(err => {
          console.log(err);
        });
    },
    sendData(data) {
      if (!this.conn.readyState) {
        setTimeout(() => {
          this.sendData(data);
        }, 100);
      } else {
        this.conn.send(JSON.stringify(data));
      }
    },
    sendMessage(text) {
      let data = {
        command: "message",
        from: this.PROFILE.id,
        to: this.$route.params.fromId,
        message: text
      };
      this.sendData(data);
    }
  },
  mounted() {
    this.getMessages();

    this.conn = new WebSocket("ws://ray-of-hope-build.loc:8091");
    this.conn.onopen = function() {
      console.log("Соединение установлено!");
    };
    this.conn.onmessage = function(e) {
      let data = JSON.parse(e.data);
      alert(data.message);
    };
    this.sendData({ command: "register", userId: this.PROFILE.id });
  }
};
</script>

<style>
.dialog {
  width: 500px;
  margin: 0 auto;
}
</style>