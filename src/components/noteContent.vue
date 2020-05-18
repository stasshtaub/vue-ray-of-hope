<template>
  <div class="note-content">
    <vue-scroll ref="vs" :ops="scrollOps">
      <div class="scroll-wrapper">
        <TextareaAutosize
          class="text-field"
          placeholder="Текст записи..."
          v-model="value"
          :min-height="100"
          @input="$emit('input', value)"
        />
        <post-image-list
          v-if="images.length"
          :images="images"
        ></post-image-list>
      </div>
    </vue-scroll>
  </div>
</template>

<script>
export default {
  name: "note-content",
  components: {
    postImageList: () => import("./postImageList"),
  },
  props: {
    images: {
      type: Array,
      default: () => [],
    },
    value: {
      type: String,
      default: "",
    },
  },
  data: () => ({
    scrollOps: {
      rail: {
        gutterOfSide: "0px",
      },
      bar: {
        background: "gray",
        width: "5px",
        opacity: 0.2,
      },
    },
  }),
};
</script>

<style>
.note-content {
  height: 300px;
  overflow: hidden;
  margin-right: -12px;
}
.text-field {
  width: 100%;
  outline: none;
  border: none;
}
</style>
