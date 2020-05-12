<template>
  <div class="guest-layout">
    <guest-navbar></guest-navbar>
    <router-view></router-view>
  </div>
</template>

<script>
import guestNavbar from "../components/guestNavbar";
export default {
  name: "guest-layout",
  components: {
    guestNavbar
  }
};
</script>

<style>
.guest-layout .container {
  position: relative;
  width: 1000px;
  max-width: calc(100% - 20px);
  padding: 0 10px;
  margin: 0 auto;
}
</style>