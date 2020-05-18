<template>
  <div class="note-content">
    <TextareaAutosize
      class="text-field"
      placeholder="Текст записи..."
      v-model="value"
      :min-height="100"
      @input="$emit('input', value)"
    />
  </div>
</template>

<script>
export default {
  name: "note-content",
  props: {
    images: {
      type: Array,
      default: () => []
    },
    value: {
      type: String,
      default: ""
    }
  }
};
</script>

<style>
.text-field {
  width: 100%;
}
</style>