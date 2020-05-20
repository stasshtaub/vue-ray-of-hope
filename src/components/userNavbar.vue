<template>
  <div class="user-navbar">
    <div class="container">
      <router-link to="/" class="logo_link">
        <logo />
      </router-link>
      <nav class="nav-links">
        <ul>
          <li class="nav-link">
            <router-link :to="'/organizations/' + PROFILE.id" id="nav-avatar">
              <avatar :img="PROFILE.avatar" :size="35" />
            </router-link>
          </li>
          <li class="nav-link">
            <router-link to="/feed">Лента</router-link>
          </li>
          <li class="nav-link">
            <router-link to="/messages">Сообщения</router-link>
          </li>
          <li class="nav-link">
            <router-link to="/organizations">Организации</router-link>
          </li>
          <li class="nav-link">
            <router-link to="#">Ответы</router-link>
          </li>
          <li class="nav-link">
            <router-link to="#">Любимые</router-link>
          </li>
          <li class="nav-link sub">
            <a href="#" @click="showSub = !showSub">Ещё</a>
            <ul class="sub-menu frame" v-if="showSub">
              <router-link to="#">Кооментарии</router-link>
              <router-link to="#">Закладки</router-link>
              <router-link to="#">F.A.Q</router-link>
              <router-link to="#">Настройки</router-link>
              <button class="link" @click="logout">Выход</button>
            </ul>
          </li>
        </ul>
      </nav>
      <input class="nav-search" type="search" placeholder="Поиск" />
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  name: "user-navbar",
  components: {
    avatar: () => import("./avatar"),
    logo: () => import("./svg/logo"),
  },
  data: () => ({
    showSub: false,
  }),
  computed: {
    ...mapGetters(["PROFILE"]),
  },
  methods: {
    ...mapActions(["AUTH_LOGOUT"]),
    logout() {
      this.AUTH_LOGOUT()
        .then(() => {
          this.$router.push("/");
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style>
.user-navbar {
  z-index: 2;
  position: fixed;
  top: 0;
  width: 100vw;
  background-color: #fff;
  height: 60px;
  box-shadow: 0 0px 5px #d6d6d6;
}
.user-navbar .container {
  position: relative;
  width: 1700px !important;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: space-around;
}
a.logo_link {
  position: absolute;
  left: 0;
}
.nav-links > ul {
  display: flex;
  align-items: center;
  list-style-type: none;
}
.nav-links > ul > li:not(:first-of-type) {
  margin-left: 50px;
}
.nav-link.sub {
  position: relative;
}
.sub-menu {
  position: absolute;
  display: grid;
  padding: 20px 25px;
  width: 140px;
  top: 50px;
  left: 50%;
  transform: translate(-50%);
  grid-gap: 15px;
}
input.nav-search {
  right: 0;
  position: absolute;
  padding: 6px 12px;
  border-radius: 12px;
  border: none;
  background: #f3f5f6;
}
</style>
