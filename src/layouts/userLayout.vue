<template>
  <div class="user-layout">
    <template v-if="PROFILE">
      <user-navbar></user-navbar>
      <div class="container">
        <keep-alive>
          <router-view :key="$route.fullPath"></router-view>
        </keep-alive>
      </div>
    </template>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import userNavbar from "../components/userNavbar";
export default {
  name: "user-layout",
  components: {
    userNavbar
  },
  computed: {
    ...mapGetters(["PROFILE"])
  }
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
</style>