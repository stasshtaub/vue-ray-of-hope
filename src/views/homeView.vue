<template>
  <div class="home-view">
    <hello-screen></hello-screen>
    <about-screen></about-screen>
  </div>
</template>

<script>
import helloScreen from "../components/helloScreen";
import aboutScreen from "../components/aboutScreen";
export default {
  name: "home-view",
  components: {
    helloScreen,
    aboutScreen
  }
};
</script>

<style>
</style>