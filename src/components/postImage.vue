<template>
  <figure :style="figureStyle">
    <i :style="iStyle"></i>
    <img :src="imgUrl" />
  </figure>
</template>

<script>
export default {
  name: "post-image",
  props: {
    imgUrl: {
      type: String,
      default: ""
    }
  },
  data: () => ({
    image: null
  }),
  created() {
    this.image = new Image();
    this.image.src = this.imgUrl;
  },
  computed: {
    figureStyle() {
      return {
        flexGrow: (this.image.width / this.image.height) * 100,
        flexBasis: (this.image.width / this.image.height) * 250 + "px"
      };
    },
    iStyle() {
      return {
        paddingBottom: (this.image.height / this.image.width) * 100.0 + "%"
      };
    }
  }
};
</script>

<style>
figure {
  position: relative;
}

figure > i {
  display: block;
}

figure > img {
  position: absolute;
  top: 0;
  width: 100%;
  vertical-align: bottom;
}
</style>