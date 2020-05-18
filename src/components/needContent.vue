<template>
  <div class="need-content">
    <textbox
      v-model="needCount"
      :placeholder="'Нужное количество'"
      :width="'200px'"
      :type="number"
    />
    <textbox
      v-model="collectedCount"
      :placeholder="'Собранное количество'"
      :width="'200px'"
      :type="number"
    />
  </div>
</template>

<script>
export default {
  name: "need-content",
  components: {
    textbox: () => import("./textbox"),
  },
  props: {
    needCount: {
      type: Int8Array,
      default: null,
    },
    collectedCount: {
      type: Int8Array,
      default: null,
    },
  },
  watch: {
    needCount() {
      this.$emit("changeNeedCount", this.needCount);
    },
    collectedCount() {
      this.$emit("changeCollectedCount", this.collectedCount);
    },
  },
};
</script>

<style>
.need-content > * {
  display: inline-block;
}
.need-content > *:not(:last-of-type) {
  margin-right: 20px;
}
</style>
