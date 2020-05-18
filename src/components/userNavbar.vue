<template>
  <div class="user-navbar">
    <div class="container">
      <router-link to="/" class="logo_link">
        <img
          class="logo"
          src="/assets/img/logo_header2.png"
          alt="Луч надежды"
        />
      </router-link>
      <nav class="nav-links">
        <ul>
          <li class="nav-link">
            <router-link :to="'/organizations/' + PROFILE.id" id="nav-avatar">
              <avatar :img="PROFILE.avatar || undefined" :size="40" />
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
              <router-link to="#">Выход</router-link>
            </ul>
          </li>
        </ul>
      </nav>
      <input class="nav-search" type="search" placeholder="Поиск" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import avatar from "./avatar";
export default {
  name: "user-navbar",
  components: {
    avatar,
  },
  data: () => ({
    showSub: false,
  }),
  computed: {
    ...mapGetters(["PROFILE"]),
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
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.nav-links > ul {
  display: flex;
  align-items: center;
  list-style-type: none;
}
.nav-links > ul > li:not(:first-of-type) {
  margin-left: 35px;
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
</style>
