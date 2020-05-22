<template>
  <div class="organizations-view">
    <router-view :key="$route.fullPath"></router-view>
  </div>
</template>

<script>
export default {
  name: "organizations-view"
};
</script>

<style>
</style>