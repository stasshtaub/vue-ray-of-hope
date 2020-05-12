<template>
  <svg class="plus-icon" :width="width+'px'" viewBox="0 0 300 300">
    <path
      d="M282,168H168V282a18,18,0,0,1-36,0V168H18a18,18,0,1,1,0-36H132V18a18,18,0,1,1,36,0V132H282A18,18,0,0,1,282,168Z"
    />
  </svg>
</template>

<script>
export default {
  name: "plus-icon",
  props: {
    width: {
      type: Uint8Array,
      default: 45
    }
  }
};
</script>

<style >
.plus-icon > path {
  fill: #bfbfbf;
}
</style>