<template>
  <div class="avatar" :style="{width: size+'px', height: size+'px'}">
    <img :src="img" alt />
  </div>
</template>

<script>
export default {
  name: "avatar",
  props: {
    img: {
      type: String,
      default: require("@/assets/img/noavatar.jpg")
    },
    size: {
      type: Int8Array,
      default: 50
    }
  }
};
</script>

<style>
.avatar {
  border-radius: 50%;
  overflow: hidden;
}
.avatar img {
  width: 100%;
}
</style>