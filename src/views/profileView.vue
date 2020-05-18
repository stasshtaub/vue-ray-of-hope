<template>
  <div class="profile-view" v-cloak>
    <profile-info :isSelf="isSelf" :userData="isSelf ? PROFILE : userData"></profile-info>
    <div class="bottom">
      <div class="sidebar">
        <switch-posts @changeType="changeType"></switch-posts>
        <button class="new-post frame" @click="showCreatePost=true">+ Новая запись</button>
      </div>
      <posts-list :posts="posts" @delete="deletePost"></posts-list>
    </div>
    <create-post v-if="showCreatePost" @close="showCreatePost=false" />
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
    postsList: () => import("../components/postsList"),
    createPost: () => import("../components/createPost")
  },
  data: () => ({
    postsType: null,
    posts: [],
    userData: {},
    showCreatePost: false
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
      await axios
        .get(
          `/api/organizations/${
            this.isSelf ? this.PROFILE.id : this.$route.params.id
          }/posts` + (this.postsType ? "?type=" + this.postsType : "")
        )
        .then(resp => {
          this.posts = resp.data.posts;
        })
        .catch(err => {
          console.log(err);
        });
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
.profile-view,
.profile-view .bottom {
  display: grid;
  grid-gap: 20px;
}
.profile-view .sidebar > *:not(last-of-type) {
  margin-bottom: 20px;
}
.profile-view .bottom {
  grid-template-columns: 22.0833333% 76.25%;
}
.new-post {
  height: 90px;
  display: flex;
  justify-content: center;
  align-items: center;
  border: none;
  width: 100%;
}
</style>
