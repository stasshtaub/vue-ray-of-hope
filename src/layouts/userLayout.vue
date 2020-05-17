<template>
  <div class="user-layout">
    <template v-if="PROFILE">
      <user-navbar></user-navbar>
      <div class="container">
        <keep-alive>
          <router-view></router-view>
        </keep-alive>
      </div>
    </template>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";
import userNavbar from "../components/userNavbar";
export default {
  name: "user-layout",
  components: {
    userNavbar,
  },
  computed: {
    ...mapGetters(["PROFILE", "UNREAD"]),
  },
  methods: {
    ...mapActions(["WS_INIT"]),
    ...mapMutations(["REMOVE_FROM_UNREAD"]),
  },
  watch: {
    PROFILE() {
      this.WS_INIT("ws://ray-of-hope-build.loc:8080");
    },
    UNREAD() {
      const mess = this.UNREAD[this.UNREAD.length - 1];
      if (this.$route.params.fromId == mess.from.id) {
        this.$root.$emit("message", mess);
      } else {
        alert(`${mess.from.name}: ${mess.text}`);
      }
    },
  },
};
</script>

<style>
.user-layout {
  min-height: 100vh;
  background-color: #f3f5f6;
}
.user-layout .container {
  width: 1000px;
  max-width: calc(100vw - 40px);
  margin: 0 auto;
}
.user-layout > .container {
  padding: 90px 0 30px 0;
}
.frame {
  border-radius: 10px;
  background-color: white;
}
button.fill,
button.contur {
  border-radius: 12px;
  padding: 8px 20px;
  border: 1px solid #007bf5;
}
button.fill {
  background-color: #007bf5;
  color: white;
}
button.contur {
  color: #007bf5;
}
</style>
