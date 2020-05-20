<template>
  <div class="feed-view">
    <posts-list :posts="posts"></posts-list>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "feed-view",
  components: {
    postsList: () => import("../components/postsList")
  },
  data: () => ({
    postsType: null,
    posts: []
  }),
  methods: {
    changeType(type) {
      this.postsType = type;
      this.getFeed();
    },
    getFeed() {
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
  },
  mounted() {
    this.getFeed();
  }
};
</script>

<style>
.feed-view {
  width: 762.5px;
  margin: 0 auto;
}
</style>
