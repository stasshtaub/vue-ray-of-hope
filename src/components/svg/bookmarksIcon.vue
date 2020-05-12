<template>
  <svg class="bookmarks-icon" :width="width+'px'" viewBox="0 0 1020.426 1021.913">
    <polygon
      points="510.213,52.062 658.765,350.311 974.44,406.699 750.576,647.416 797.121,980.516 510.213,831.037 223.305,980.516 269.85,647.416 45.986,406.699 361.661,350.311 "
    />
  </svg>
</template>

<script>
export default {
  name: "bookmarks-icon",
  props: {
    width: {
      type: Uint8Array,
      default: 25
    }
  }
};
</script>

<style >
.bookmarks-icon > polygon {
  stroke: #bfbfbf;
  stroke-width: 50px;
  fill: none;
}
</style>