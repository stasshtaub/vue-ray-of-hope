<template>
  <div class="messages-view">
    <dialogs-list :dialogs="dialogs"></dialogs-list>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
  name: "messages-view",
  components: {
    dialogsList: () => import("../components/dialogsList")
  },
  data: () => ({
    dialogs: []
  }),
  computed: {
    ...mapGetters(["IS_AUTHENTICATED"])
  },
  methods: {
    getDialogs() {
      if (this.IS_AUTHENTICATED) {
        axios
          .get("/api/dialog")
          .then(resp => {
            this.dialogs = resp.data.dialogs;
          })
          .catch(err => {
            console.log(err);
          });
      }
    }
  },
  mounted() {
    this.getDialogs();
  }
};
</script>

<style>
</style>