<template>
  <form class="message-box" @submit.prevent="send">
    <input
      type="text"
      class="message-input"
      placeholder="Сообщение..."
      v-model="text"
    />
    <button type="submit">Отправить</button>
  </form>
</template>

<script>
export default {
  name: "message-box",
  data: () => ({
    text: "",
  }),
  methods: {
    send() {
      this.$emit("send", this.text);
      this.text = "";
    },
  },
};
</script>

<style>
.message-box {
  display: grid;
  grid-template-columns: 1fr fit-content(100px);
  grid-gap: 10px;
  box-shadow: 0 0px 5px #0000001f;
}
.message-input {
  outline: 0;
  padding: 15px;
  border: none;
}
.message-box > button {
  border: none;
  background: none;
  color: #007bf5;
  padding: 0 20px;
}
</style>
