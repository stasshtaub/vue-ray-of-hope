<template>
  <div class="dialogs-list">
    <dialogs-list-item
      v-for="dialog in dialogs"
      :key="dialog.userFrom"
      :dialog="dialog"
    ></dialogs-list-item>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "dialogs-list",
  components: {
    dialogsListItem: () => import("./dialogsListItem"),
  },
  data: () => ({
    dialogs: [],
  }),
  methods: {
    getDialogs() {
      axios
        .get("/api/dialogs")
        .then((resp) => {
          this.dialogs = resp.data.dialogs;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.getDialogs();
  },
};
</script>

<style>
.dialogs-list {
  display: grid;
  grid-gap: 20px;
  width: 500px;
  margin: 0 auto;
}
</style>
