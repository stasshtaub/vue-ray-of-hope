<template>
  <div class="description-limited">
    <p class="title">Описание:</p>
    <p class="text">{{limitedText}}</p>
    <span
      class="show-full"
      v-if="text.length>limit"
      @click="showFull=!showFull"
    >{{showFull?' скрыть':' больше...'}}</span>
  </div>
</template>

<script>
export default {
  name: "description-limited",
  props: {
    text: {
      type: String,
      default: ""
    },
    limit: {
      type: Int8Array,
      default: 180
    }
  },
  data: () => ({
    showFull: false
  }),
  computed: {
    limitedText() {
      return this.showFull ? this.text : this.text.substring(0, this.limit);
    }
  }
};
</script>

<style>
.description-limited > .show-full {
  cursor: pointer;
  color: #2b86f6;
}
.description-limited > .text {
  display: inline;
  color: #a1a1a1;
}
</style>