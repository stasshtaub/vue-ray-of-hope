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
        gutterOfEnds: "20px",
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
.__view {
  display: flex;
}
.messages-list {
  padding: 0 8px 0 20px;
  overflow: hidden;
}
.messages-list .scroll-wrapper {
  width: 100%;
  margin-top: auto;
}
.messages-list .message:first-of-type {
  margin-top: 20px;
}
.messages-list .message {
  margin-bottom: 20px;
}
</style>
