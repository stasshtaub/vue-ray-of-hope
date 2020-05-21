<template>
  <div class="signup-form-org form-wrapper">
    <h1 class="form-title">РЕГИСТРАЦИЯ ОРГАНИЗАЦИИ</h1>
    <form @submit.prevent="register">
      <form-textbox
        v-for="(textbox, key) in textBoxes"
        :key="key"
        :type="textbox.type"
        :placeholder="textbox.placeholder"
        :error="textbox.error"
        :tooltip="textbox.tooltip"
        v-model="textbox.value"
      ></form-textbox>
      <button type="submit">Зарегистрироваться</button>
    </form>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import formTextbox from "./formTextbox";
export default {
  name: "signup-form-org",
  components: { formTextbox },
  data: () => ({
    textBoxes: {
      name: {
        value: "",
        type: "text",
        placeholder: "Название",
        tooltip:
          "Зарегистрированное<br>или привычное для граждан<br>название организации",
        error: ""
      },
      inn: {
        value: "",
        type: "text",
        placeholder: "ИНН",
        tooltip: "10 цифр",
        error: ""
      },
      email: {
        value: "",
        placeholder: "E-mail",
        type: "email",
        tooltip: "",
        error: ""
      },
      password: {
        value: "",
        placeholder: "Пароль",
        type: "password",
        tooltip: "Минимум 8 знаков: цифры и латинские буквы",
        error: ""
      },
      confirmPassword: {
        value: "",
        placeholder: "Подтверждение пароля",
        type: "password",
        tooltip: "",
        error: ""
      }
    }
  }),
  methods: {
    ...mapActions(["ORG_SIGNUP_REQUEST"]),
    updateValue(key, value) {
      this.textBoxes[key].value = value;
    },
    validateInn() {
      let inn = this.textBoxes.inn.value;
      if (inn.match(/\D/)) return false;
      let len = inn.length;

      if (len === 10) {
        return (
          inn[9] ===
          ((2 * inn[0] +
            4 * inn[1] +
            10 * inn[2] +
            3 * inn[3] +
            5 * inn[4] +
            9 * inn[5] +
            4 * inn[6] +
            6 * inn[7] +
            8 * inn[8]) %
            11) %
            10
        ).toString();
      } else if (len === 12) {
        let num10 = (
          ((7 * inn[0] +
            2 * inn[1] +
            4 * inn[2] +
            10 * inn[3] +
            3 * inn[4] +
            5 * inn[5] +
            9 * inn[6] +
            4 * inn[7] +
            6 * inn[8] +
            8 * inn[9]) %
            11) %
          10
        ).toString();

        let num11 = (
          ((3 * inn[0] +
            7 * inn[1] +
            2 * inn[2] +
            4 * inn[3] +
            10 * inn[4] +
            3 * inn[5] +
            5 * inn[6] +
            9 * inn[7] +
            4 * inn[8] +
            6 * inn[9] +
            8 * inn[10]) %
            11) %
          10
        ).toString();

        return inn[11] === num11 && inn[10] === num10;
      }

      return false;
    },
    validateEmail() {
      let email = this.textBoxes.email.value;
      let mailFormat = new RegExp(
        "([a-zA-Z0-9_.-]+)@([a-zA-Z0-9_.-]+)\\.([a-zA-Z]{2,5})"
      );
      return mailFormat.test(email);
    },
    validate() {
      let errors = {};
      for (let key in this.textBoxes) {
        this.textBoxes[key].error = "";
        if (!this.textBoxes[key].value) {
          errors[key] = "Заполните это поле";
        } else {
          switch (key) {
            case "name":
              if (this.textBoxes[key].value.length > 255) {
                errors[key] = "Название слишком длинное";
              }
              break;
            case "inn":
              if (!this.validateInn()) {
                errors[key] = "Некорректный инн";
              }
              break;
            case "email":
              if (!this.validateEmail()) {
                errors[key] = "Некорректный E-mail";
              }
              break;
            case "password":
              var pass = this.textBoxes.password.value;
              if (
                pass.length < 8 ||
                pass.length > 100 ||
                pass.match(/^([^0-9]*|[^A-Z]*)$/)
              ) {
                errors[key] = "Некорректный пароль";
              } else if (pass != this.textBoxes.confirmPassword.value) {
                errors["confirmPassword"] = "Пароли не совпадают";
              }
              break;
          }
        }
      }
      return errors;
    },
    async register() {
      let validateResult = this.validate();
      console.log(validateResult);
      if (!Object.keys(validateResult).length) {
        await this.ORG_SIGNUP_REQUEST({
          email: this.textBoxes.email.value,
          inn: this.textBoxes.inn.value,
          password: this.textBoxes.password.value,
          confirmPassword: this.textBoxes.confirmPassword.value,
          name: this.textBoxes.name.value
        })
          .then(() => {
            console.log(this.PROFILE);
            this.$router.push("/");
          })
          .catch(error => {
            switch (error.response.status) {
              case 400:
                alert("Неверный запрос: " + error.response.data.status);
                break;
              case 422:
                for (var key in error.response.data.errors) {
                  this.textBoxes[key].error = error.response.data.errors[key];
                }
                break;
              case 500:
                alert("Ошибка сервера: " + error.response.data.status);
                break;
              default:
                alert(
                  "Что-то пошло не так, код ошибки: " + error.response.status
                );
            }
          });
      } else {
        for (let key in validateResult) {
          this.textBoxes[key].error = validateResult[key];
        }
      }
    }
  },
  computed: {
    ...mapGetters(["PROFILE"])
  }
};
</script>

<style>
.signup-form-org form {
  grid-template-rows: repeat(6, 40px);
}
</style>