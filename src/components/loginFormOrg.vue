<template>
  <div class="login-form-org form-wrapper">
    <h1 class="form-title">АВТОРИЗАЦИЯ ОРГАНИЗАЦИИ</h1>
    <form>
      <form-textbox
        v-for="(textbox, key) in textBoxes"
        :key="key"
        :type="textbox.type"
        :placeholder="textbox.placeholder"
      ></form-textbox>
      <button type="submit" id="login-button">Войти</button>
    </form>
    <a href class="forgotPass">Забыли пароль?</a>
  </div>
</template>

<script>
import formTextbox from "./formTextbox.vue";
export default {
  name: "login-form-org",
  components: {
    formTextbox
  },
  data: () => ({
    textBoxes: {
      emailOrInn: {
        type: "text",
        placeholder: "E-mail или ИНН"
      },
      password: {
        placeholder: "Пароль",
        type: "password"
      }
    }
  })
};
</script>

<style>
.login-form-org form {
  grid-template-rows: repeat(3, 40px);
}
</style>