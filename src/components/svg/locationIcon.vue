<template>
  <svg class="location-icon" :width="width+'px'" viewBox="0 0 49.29 72.89">
    <path
      d="M24.81 72.89c0,0 -24.81,-32.35 -24.81,-48.43 0,-13.52 11.03,-24.46 24.65,-24.46 13.61,0 24.64,10.94 24.64,24.46 0,16.77 -24.48,48.43 -24.48,48.43zm-0.33 -59.3c-6.15,0 -11.12,4.94 -11.12,11.06 0,6.09 4.97,11.03 11.12,11.03 6.15,0 11.12,-4.94 11.12,-11.03 0,-6.12 -4.97,-11.06 -11.12,-11.06z"
    />
  </svg>
</template>

<script>
export default {
  name: "location-icon",
  props: {
    width: {
      type: Uint8Array,
      default: 15
    }
  }
};
</script>

<style >
.location-icon > path {
  fill: #bfbfbf;
}
</style>