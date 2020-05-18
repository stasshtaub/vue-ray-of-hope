<template>
  <div class="textbox">
    <div v-if="name" class="textbox-title">{{ name }}</div>
    <input
      v-if="type == 'input'"
      type="text"
      v-model="value"
      :style="{ width: `calc(${width} - 24px)` }"
      :placeholder="placeholder"
      @input="$emit('input', value)"
    />
    <textarea
      v-else-if="type == 'textarea'"
      rows="3"
      v-model="value"
      :style="{ width: `calc(${width} - 24px)` }"
      :placeholder="placeholder"
      @input="$emit('input', value)"
    ></textarea>
  </div>
</template>

<script>
export default {
  name: "textbox",
  props: {
    type: {
      type: String,
      default: "input",
    },
    width: {
      type: String,
      default: "100%",
    },
    value: {
      type: String,
      default: "",
    },
    name: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
  },
};
</script>

<style>
.textbox {
  position: relative;
}
.textbox-title {
  position: absolute;
  color: #a1a1a1;
  background-color: #fff;
  font-size: 0.8rem;
  top: -10px;
  left: 9px;
  padding: 0 4px;
}
.textbox > *:not(.textbox-title) {
  padding: 8px 12px;
  border-radius: 12px;
  border: 1px solid #d9d9d9;
}
textarea {
  resize: none;
}
</style>
