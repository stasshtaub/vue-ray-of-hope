<template>
  <div class="user-layout">
    <template v-if="PROFILE">
      <user-navbar></user-navbar>
      <vue-scroll :ops="scrollOps">
        <div class="container content">
          <keep-alive>
            <router-view></router-view>
          </keep-alive>
        </div>
      </vue-scroll>
    </template>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";
import userNavbar from "../components/userNavbar";
export default {
  name: "user-layout",
  components: {
    userNavbar,
  },

  data: () => ({
    scrollOps: {
      rail: {
        gutterOfSide: "5px",
        gutterOfEnds: "5px",
      },
      bar: {
        background: "gray",
        width: "5px",
        opacity: 0.4,
      },
    },
  }),
  computed: {
    ...mapGetters(["PROFILE", "UNREAD"]),
  },
  methods: {
    ...mapActions(["WS_INIT"]),
    ...mapMutations(["REMOVE_FROM_UNREAD"]),
  },
  watch: {
    PROFILE() {
      this.WS_INIT("ws://ray-of-hope-build.loc:8080");
    },
    UNREAD() {
      const mess = this.UNREAD[this.UNREAD.length - 1];
      if (this.$route.params.fromId == mess.from.id) {
        this.$root.$emit("message", mess);
      } else {
        alert(`${mess.from.name}: ${mess.text}`);
      }
    },
  },
};
</script>

<style>
.user-layout {
  padding-top: 60px;
  height: calc(100vh - 60px);
  background-color: #f3f5f6;
}
.user-layout .container {
  width: 1000px;
  max-width: calc(100vw - 40px);
  margin: 0 auto;
}
.user-layout .container.content {
  padding-top: 30px;
  padding-bottom: 30px;
}
.frame {
  border-radius: 10px;
  background-color: white;
}
button.fill,
button.contur {
  border-radius: 12px;
  padding: 8px 20px;
  border: 1px solid #007bf5;
}
button.fill {
  background-color: #007bf5;
  color: white;
}
button.contur {
  color: #007bf5;
}
button.link {
  border: none;
  background: none;
  color: #007bf5;
}
button.icon {
  line-height: 0;
  border: none;
  background: none;
}
.scroll-wrapper {
  padding-right: 12px;
}
</style>
