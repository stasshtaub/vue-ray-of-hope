<template>
  <div id="app">
    <component :is="currentLayout"></component>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import guestLayout from "./layouts/guestLayout";
import userLayout from "./layouts/userLayout";

export default {
  name: "App",
  components: {
    guestLayout,
    userLayout,
  },
  computed: {
    ...mapGetters(["IS_AUTHENTICATED"]),
    currentLayout() {
      return this.IS_AUTHENTICATED ? userLayout : guestLayout;
    },
  },
  methods: {
    ...mapActions(["LOGIN_WITH_TOKEN"]),
  },
  mounted() {
    if (this.IS_AUTHENTICATED) {
      this.LOGIN_WITH_TOKEN();
    }
  },
  watch: {
    IS_AUTHENTICATED() {
      this.$router.go(this.$router.currentRoute);
    },
  },
};
</script>

<style>
@font-face {
  font-family: "Segoe";
  src: url("~@/assets/fonts/SegoeUI.eot");
  src: local("☺"), url("~@/assets/fonts/SegoeUI.woff") format("woff"),
    url("~@/assets/fonts/SegoeUI.ttf") format("truetype");
  font-weight: normal;
  font-style: normal;
}
@font-face {
  font-family: "SegoeLight";
  src: url("~@/assets/fonts/SegoeUI-Light.eot");
  src: local("☺"), url("~@/assets/fonts/SegoeUI-Light.woff") format("woff"),
    url("~@/assets/fonts/SegoeUI-Light.ttf") format("truetype");
  font-weight: lighter;
  font-style: normal;
}
@font-face {
  font-family: "SegoeSB";
  src: url("~@/assets/fonts/SegoeUI-SemiBold.eot");
  src: local("☺"), url("~@/assets/fonts/SegoeUI-SemiBold.woff") format("woff"),
    url("~@/assets/fonts/SegoeUI-SemiBold.ttf") format("truetype");
  font-weight: bold;
  font-style: normal;
}
[v-cloak] {
  display: none;
}
* {
  margin: 0;
  padding: 0;
  font-family: "Segoe", sans-serif;
  font-size: 1rem;
  line-height: 1.35em;
}
body {
  overflow: hidden;
}
button {
  cursor: pointer;
}
a {
  text-decoration: none;
}
</style>
