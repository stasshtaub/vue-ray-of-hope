<template>
  <div class="guest-layout">
    <guest-navbar></guest-navbar>
    <vue-scroll :ops="scrollOps" @handle-scroll="handleScroll">
      <router-view></router-view>
    </vue-scroll>
  </div>
</template>

<script>
import guestNavbar from "../components/guestNavbar";
export default {
  name: "guest-layout",
  components: {
    guestNavbar,
  },
  data: () => ({
    scrollOps: {
      rail: {
        gutterOfSide: "5px",
        gutterOfEnds: "5px",
      },
      bar: {
        background: "gray",
        width: "5px",
        opacity: 0.4,
      },
    },
  }),
  methods: {
    handleScroll(vertical) {
      this.$root.$emit("home-scroll", vertical);
    },
  },
};
</script>

<style>
.guest-layout {
  height: 100vh;
}
.guest-layout .container {
    position: relative;
    width: 1000px;
    max-width: calc(100% - 20px);
    padding: 0 10px;
    margin: 0 auto;
}
</style>
