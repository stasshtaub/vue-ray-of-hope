<template>
  <div class="guest-navbar" :class="{ scroll: scroll }">
    <div class="container">
      <router-link to="/">
        <logo :height="60" />
      </router-link>
      <nav class="nav-links">
        <ul>
          <li class="nav-link">
            <router-link to="/#about">О нас</router-link>
          </li>
          <li id="login" class="nav-link sub">
            <a @click="subMenu = subMenu != 'login' ? 'login' : ''">Вход</a>
            <ul class="sub-menu" v-if="subMenu == 'login'">
              <router-link to="#">Гражданин</router-link>
              <router-link to="/login/organization">Организация</router-link>
            </ul>
          </li>
          <li id="reg" class="nav-link sub">
            <a @click="subMenu = subMenu != 'signup' ? 'signup' : ''"
              >Регистрация</a
            >
            <ul class="sub-menu" v-if="subMenu == 'signup'">
              <router-link to="#">Гражданин</router-link>
              <router-link to="/signup/organization">Организация</router-link>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  name: "guest-navbar",
  data: () => ({
    subMenu: "",
    scroll: false,
  }),
  components: {
    logo: () => import("./svg/logo"),
  },
  mounted() {
    this.$root.$on("home-scroll", (vertical) => {
      console.log(vertical);
      this.scroll = !!vertical.scrollTop;
    });
  },
};
</script>

<style>
.guest-navbar {
  padding-top: 10px;
  z-index: 1;
  width: 100%;
  position: fixed;
  right: 0;
  height: 80px;
}
.guest-navbar,
.guest-navbar * {
  transition: all 0.6s ease;
  font-family: "SegoeLight", sans-serif;
  font-weight: lighter;
}
.guest-navbar.scroll {
  background: white;
  height: 65px;
  padding-top: 0;
}
.guest-navbar > .container {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.guest-navbar * {
  font-weight: lighter;
  color: #ffffff99;
}
.guest-navbar.scroll * {
  color: #a3a3a3;
}
.guest-navbar .nav-links > ul {
  display: flex;
}
.guest-navbar .nav-link {
  margin-left: 30px;
  list-style-type: none;
}
.guest-navbar .nav-link.sub {
  position: relative;
}
.guest-navbar .nav-link > a {
  text-transform: uppercase;
  letter-spacing: 0.17rem;
  cursor: pointer;
}
.guest-navbar .sub-menu {
  display: grid;
  position: absolute;
  width: 130px;
  top: 30px;
  left: 50%;
  transform: translate(-50%, 0);
  grid-gap: 10px;
}

.guest-navbar.scroll .sub-menu {
  box-shadow: rgba(0, 0, 0, 0.07) 0 5px 14px;
  border-radius: 13px;
  background-color: white;
  top: 50px;
  padding: 10px 0;
}
.guest-navbar .sub-menu > a {
  border: solid rgba(255, 255, 255, 0.6) 1px;
  border-radius: 14px;
  padding: 5px 0;
  text-align: center;
}
.guest-navbar.scroll .sub-menu > a {
  border: none;
}
.guest-navbar .logo {
  width: 60px;
}
.guest-navbar.scroll .logo {
  height: 40px;
}
.guest-navbar .hand,
.guest-navbar .heart {
  fill: white !important;
}
.guest-navbar.scroll .hand {
  fill: #5bacd3 !important;
}
.guest-navbar.scroll .heart {
  fill: #ef245b !important;
}
</style>
