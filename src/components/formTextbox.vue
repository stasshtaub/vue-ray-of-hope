<template>
  <div class="form-textbox">
    <div class="tooltip" v-if="error || tooltip" @click="click">
      {{error ? "!" : "?"}}
      <div
        class="hint"
        v-if="error && !hideError || tooltip && !hideTooltip"
        v-html="error || tooltip"
      ></div>
    </div>
    <input :type="type" :placeholder="placeholder" @input="updateValue($event.target.value)" />
  </div>
</template>

<script>
export default {
  name: "form-textbox",
  props: {
    value: {
      type: String,
      default: null
    },
    type: {
      type: String,
      default: "text"
    },
    placeholder: {
      type: String,
      default: ""
    },
    tooltip: {
      type: String,
      default: ""
    },
    error: {
      type: String,
      default: ""
    }
  },
  data: () => ({
    hideError: false,
    hideTooltip: true
  }),
  methods: {
    async updateValue(value) {
      this.$emit("input", value);
    },
    click() {
      if (this.error) {
        this.hideError = !this.hideError;
      } else {
        this.hideTooltip = !this.hideTooltip;
      }
    }
  }
};
</script>

<style>
.form-textbox {
  position: relative;
}
.tooltip {
  cursor: pointer;
  user-select: none;
  position: absolute;
  right: 10px;
  top: 50%;
  padding: 5px;
  transform: translateY(-50%);
  color: #ffffff8a;
  background: transparent;
}
.hint {
  user-select: unset;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  left: 100%;
  text-align: center;
  width: max-content;
  background-color: #f74c4c;
  color: white;
  border-radius: 12px;
  padding: 7px 13px;
  font-size: 0.88rem;
}
</style>