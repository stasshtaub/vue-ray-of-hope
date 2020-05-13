<template>
  <div class="login-form-org form-wrapper">
    <h1 class="form-title">АВТОРИЗАЦИЯ ОРГАНИЗАЦИИ</h1>
    <form @submit.prevent="login">
      <form-textbox
        v-for="(textbox, key) in textBoxes"
        v-model="textbox.value"
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
import { mapActions, mapGetters } from "vuex";
import formTextbox from "./formTextbox.vue";
export default {
  name: "login-form-org",
  components: {
    formTextbox,
  },
  data: () => ({
    textBoxes: {
      emailOrInn: {
        value: "",
        type: "text",
        placeholder: "E-mail или ИНН",
      },
      password: {
        value: "",
        placeholder: "Пароль",
        type: "password",
      },
    },
  }),
  computed: {
    ...mapGetters(["IS_AUTHENTICATED"]),
  },
  methods: {
    ...mapActions(["LOGIN"]),
    login() {
      this.LOGIN({
        emailOrInn: this.textBoxes.emailOrInn.value,
        password: this.textBoxes.password.value,
      })
        .then(() => {
          if (this.IS_AUTHENTICATED) {
            //this.$router.push("/");
            //this.$router.go(this.$router.currentRoute)
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style>
.login-form-org form {
  grid-template-rows: repeat(3, 40px);
}
</style>
