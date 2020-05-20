<template>
  <div class="posts-list">
    <post v-for="post in posts" :key="post.id" :post="post" @delete="deletePost(post)"></post>
  </div>
</template>

<script>
export default {
  name: "posts-list",
  components: {
    post: () => import("./post")
  },
  props: {
    posts: {
      type: Array,
      default: () => []
    }
  },
  methods: {
    deletePost(post) {
      this.$emit("delete", post);
    }
  }
};
</script>

<style>
.posts-list {
  display: grid;
  grid-template-rows: min-content;
  grid-gap: 20px;
}
</style>
