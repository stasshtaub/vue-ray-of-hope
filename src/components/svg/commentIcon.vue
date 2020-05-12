<template>
  <svg class="comment-icon" :width="width+'px'" viewBox="0 0 1000 928">
    <defs />
    <path
      d="M875.7,647.826H573.7C539.363,676.239,458.076,744.128,387,808.24c-47.3,42.663-84.261,87.086-135.592,87.086-60.891,0-67.8-38.99-67.8-87.086v-152.4c0-2.7.146-5.37,0.4-8.009H146.891c-49.925,0-112.994-38.983-112.994-87.078V119.56c0-48.1,40.471-87.085,90.4-87.085H875.7c49.924,0,90.4,38.99,90.4,87.085V560.748C966.1,608.843,925.628,647.826,875.7,647.826Z"
    />
    <path d="M193.989,232v-1H692.011v1H193.989Zm302.2,152.141H194.145v-1H496.191v1Z" />
  </svg>
</template>

<script>
export default {
  name: "comment-icon",
  props: {
    width: {
      type: Uint8Array,
      default: 28
    }
  }
};
</script>

<style >
.comment-icon > path {
  fill: none;
  stroke: #bfbfbf;
  stroke-linejoin: round;
  stroke-width: 50px;
  fill-rule: evenodd;
}
</style>