<template>
  <div class="message-box">
    <input type="text" class="message-input" v-model="text" />
    <button @click="$emit('send', text)">Отправить</button>
  </div>
</template>

<script>
export default {
  name: "message-box",
  text: ""
};
</script>

<style>
.message-box {
  display: grid;
  grid-template-columns: 1fr 100px;
  grid-gap: 10px;
}
</style>