<template>
  <svg class="delete-icon" :width="width+'px'" viewBox="0 0 950 950">
    <path
      d="M545.7,474.98l388.911,388.9A50,50,0,1,1,863.908,934.6L475,545.687,86.087,934.6A50,50,0,1,1,15.38,863.884l388.91-388.9L15.38,86.068a49.994,49.994,0,0,1,70.707-70.7L475,404.274l388.911-388.9a49.994,49.994,0,1,1,70.707,70.7Z"
    />
  </svg>
</template>

<script>
export default {
  name: "delete-icon",
  props: {
    width: {
      type: Uint8Array,
      default: 20
    }
  }
};
</script>

<style >
.delete-icon > path {
  fill: #bfbfbf;
}
</style>