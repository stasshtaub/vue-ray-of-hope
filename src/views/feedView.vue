<template>
  <div class="feed-view">
    <posts-list :posts="posts"></posts-list>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
  name: "profile-view",
  components: {
    postsList: () => import("../components/postsList")
  },
  data: () => ({
    postsType: null,
    posts: []
  }),
  computed: {
    ...mapGetters(["PROFILE"])
  },
  methods: {
    changeType(type) {
      this.postsType = type;
      this.getProducts();
    },
    getProducts() {
      if (this.PROFILE) {
        axios
          .get("/api/feed", {
            params: {
              type: this.postsType
            }
          })
          .then(resp => {
            this.posts = resp.data.posts;
          })
          .catch(err => {
            console.log(err);
          });
      }
    }
  },
  mounted() {
    this.getProducts();
  }
};
</script>

<style>
.feed-view {
  display: grid;
  grid-template-columns: 500px;
  grid-gap: 20px;
}
</style>