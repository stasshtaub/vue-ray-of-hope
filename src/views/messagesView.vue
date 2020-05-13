<template>
  <div class="messages-view">
    <router-view :key="$route.fullPath"/>
  </div>
</template>

<script>
export default {
  name: "messages-view",
};
</script>