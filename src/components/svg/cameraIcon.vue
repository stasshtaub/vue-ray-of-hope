<template>
  <svg class="camera-icon" :width="width+'px'" viewBox="0 0 300 300">
    <circle class="back-round" cx="150" cy="150" r="150" />
    <path
      d="M196.253,212.115H104.2A36.848,36.848,0,0,1,67.381,175.24V125.2A36.848,36.848,0,0,1,104.2,88.32h18.41V85.687a13.16,13.16,0,0,1,13.15-13.17h28.38a13.16,13.16,0,0,1,13.15,13.17V88.32h18.961A36.848,36.848,0,0,1,233.074,125.2V175.24A36.848,36.848,0,0,1,196.253,212.115Z"
    />
    <circle class="inner-round" cx="151.547" cy="148.891" r="31.547" />
  </svg>
</template>

<script>
export default {
  name: "camera-icon",
  props: {
    width: {
      type: Uint8Array,
      default: 40
    }
  }
};
</script>

<style >
.camera-icon path,
.inner-round {
  fill: none;
  stroke: #fff;
  stroke-width: 10.169px;
}
.camera-icon .back-round {
  fill: #007bf5;
}
</style>