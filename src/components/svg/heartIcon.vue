<template>
  <svg class="heart-icon" :width="width+'px'" viewBox="0 0 77.5 65.75">
    <path
      d="M38.75 65.75l32.29 -28.09c4.13,-4.13 6.46,-9.75 6.46,-15.6 0,-12.18 -9.88,-22.06 -22.06,-22.06 -6.68,0 -12.65,2.96 -16.69,7.63 -4.04,-4.67 -10.01,-7.63 -16.69,-7.63 -12.18,0 -22.06,9.88 -22.06,22.06 0,5.85 2.32,11.47 6.46,15.6l32.29 28.09z"
    />
  </svg>
</template>

<script>
export default {
  name: "heart-icon",
  props: {
    width: {
      type: Uint8Array,
      default: 19
    }
  }
};
</script>

<style >
.heart-icon > path {
  fill: #bfbfbf;
}
</style>