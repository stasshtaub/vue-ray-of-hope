<template>
  <div class="avatar" :style="style">
    <img :src="img || require('@/assets/img/noavatar.jpg')" alt />
  </div>
</template>

<script>
export default {
  name: "avatar",
  props: {
    img: {
      type: String,
      default: null,
    },
    size: {
      type: Int8Array,
      default: 50,
    },
  },
  computed: {
    style() {
      let style = {
        width: this.size + "px",
        height: this.size + "px",
      };
      if (!this.img) {
        style.border = "1px solid #b7b7b7";
      }
      return style;
    },
  },
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
