<template>
  <svg class="arrow-down-icon" :width="width+'px'" viewBox="0 0 299.813 166.282">
    <path
      d="M294.726,30.647L163.441,161.573a17.694,17.694,0,0,1-13.42,5.111,17.7,17.7,0,0,1-13.42-5.111L5.316,30.647A17.752,17.752,0,0,1,30.456,5.576L150.021,124.814,269.586,5.576A17.752,17.752,0,1,1,294.726,30.647Z"
      transform="translate(-0.125 -0.406)"
    />
  </svg>
</template>

<script>
export default {
  name: "arrow-down-icon",
  props: {
    width: {
      type: Uint8Array,
      default: 20
    }
  }
};
</script>

<style >
.arrow-down-icon > path {
  fill: #bfbfbf;
}
</style>