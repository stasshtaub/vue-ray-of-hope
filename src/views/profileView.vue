<template>
  <div class="profile-view" v-cloak>
    <profile-info :isSelf="isSelf" :userData="isSelf ? PROFILE: userData"></profile-info>
    <switch-posts @changeType="changeType"></switch-posts>
    <posts-list :posts="posts" @delete="deletePost"></posts-list>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "profile-view",
  components: {
    profileInfo: () => import("../components/profileInfo"),
    switchPosts: () => import("../components/switchPosts"),
    postsList: () => import("../components/postsList")
  },
  data: () => ({
    postsType: null,
    posts: [],
    userData: {}
  }),
  computed: {
    ...mapGetters(["PROFILE"]),
    isSelf() {
      return this.PROFILE ? this.PROFILE.id == this.$route.params.id : false;
    }
  },
  methods: {
    ...mapActions(["DELETE_POST"]),
    changeType(type) {
      this.postsType = type;
      this.requestPosts();
    },
    async requestPosts() {
      if (this.PROFILE) {
        await axios
          .get(
            `/api/organizations/${
              this.isSelf ? this.PROFILE.id : this.$route.params.id
            }/posts`
          )
          .then(resp => {
            this.posts = resp.data.posts;
          })
          .catch(err => {
            console.log(err);
          });
      }
    },
    async requestUserData() {
      await axios
        .get("/api/organizations/" + this.$route.params.id)
        .then(resp => {
          this.userData = resp.data.profile;
        })
        .catch(err => {
          console.log(err);
        });
    },
    async deletePost(post) {
      this.DELETE_POST(post)
        .then(() => {
          let index = this.posts.indexOf(post);
          this.posts.splice(index, 1);
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  mounted() {
    if (!this.isSelf) {
      this.requestUserData();
    }
    this.requestPosts();
  }
};
</script>

<style>
.profile-view {
  display: grid;
  grid-template-columns: 22.0833333% 76.25%;
  grid-gap: 20px;
}
.profile-view .posts-list {
  grid-area: 2/2/3/3;
}
</style>