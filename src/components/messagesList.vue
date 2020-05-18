<template>
  <div class="messages-list">
    <vue-scroll ref="vs" :ops="scrollOps">
      <div class="scroll-wrapper">
        <message
          v-for="message in messages"
          :key="message.id"
          :message="message"
        />
      </div>
    </vue-scroll>
  </div>
</template>

<script>
export default {
  name: "messages-list",
  components: {
    message: () => import("./message"),
  },
  props: {
    messages: {
      type: Array,
      default: () => [],
    },
    pushed: {
      type: Boolean,
      default: false,
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
  methods: {
    scrollToLast(speed = 0) {
      this.$refs["vs"].scrollIntoView(".message:last-of-type", speed);
    },
  },
  updated() {
    if (this.pushed) {
      this.scrollToLast(300);
    } else {
      this.scrollToLast();
    }
  },
};
</script>

<style>
.messages-list {
  padding: 20px 8px 20px 20px;
  overflow: hidden;
}
.messages-list .message:not(:last-of-type) {
  margin-bottom: 20px;
}
</style>
