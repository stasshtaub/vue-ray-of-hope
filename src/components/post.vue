<template>
  <article class="post frame">
    <header>
      <router-link class="author" :to="'/organizations/' + post.author.id">
        <avatar :img="post.author.avatar || undefined" />
        <p class="name">{{ post.author.name }}</p>
      </router-link>
      <div class="wrp-right">
        <p class="date">{{ post.date }}</p>
        <button class="delete" v-if="isSelf" @click="$emit('delete')">
          <delete-icon />
        </button>
      </div>
    </header>
    <div class="content">
      <p class="post_text">{{ post.text }}</p>
      <post-image-list
        v-if="post.images.length"
        :images="post.images"
      ></post-image-list>
      <div v-if="post.eventData" class="location_date">
        <location-icon :width="20" />
        <div class="location_date_wrapper">
          <p class="date">{{ post.eventData.date }}</p>
          <p class="location">{{ post.eventData.location }}</p>
        </div>
      </div>
      <div v-if="post.needData" class="progress">
        <div class="count">
          <span class="collected_count">{{
            post.needData.collectedCount
          }}</span>
          <span class="need_count">{{ post.needData.needCount }}</span>
        </div>
        <div class="bar">
          <div class="line_full">
            <div class="line_collected"></div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <a href class="comments">
        <comment-icon />
        <p class="post_comments_count">0</p>
      </a>
      <button class="bookmarks">
        <bookmarks-icon />
      </button>
    </footer>
  </article>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "post",
  props: {
    post: {
      type: Object,
      default: () => ({
        id: null,
        author: {},
        text: null,
        images: [],
        date: null,
        eventData: null,
        needData: null,
      }),
    },
  },
  components: {
    postImageList: () => import("./postImageList"),
    avatar: () => import("./avatar"),
    deleteIcon: () => import("./svg/deleteIcon"),
    commentIcon: () => import("./svg/commentIcon"),
    bookmarksIcon: () => import("./svg/bookmarksIcon"),
    locationIcon: () => import("./svg/locationIcon"),
  },
  computed: {
    ...mapGetters(["PROFILE"]),
    isSelf() {
      return this.PROFILE ? this.PROFILE.id == this.post.author.id : false;
    },
  },
};
</script>

<style>
.post {
  overflow: hidden;
  padding: 25px;
}

.post,
.post > .content {
  grid-template-columns: 100%;
  display: grid;
  grid-gap: 15px;
}

.post * {
  color: #bfbfbf;
}
.post .post_text {
  color: black;
}
.post button {
  border: none;
  background: none;
  font-size: 0;
}

.post > header,
.post > footer {
  display: flex;
}

.post > header > .wrp-right {
  margin-left: auto;
}

.post > header > .author > .name {
  margin-left: 20px;
  color: #2b86f6;
}

.post > header button.delete {
  margin-left: 25px;
}

.post .author,
.post .wrp-right,
.post .location_date,
.post .comments {
  display: flex;
  align-items: center;
}

.location_date_wrapper {
  margin-left: 15px;
}

.location_date_wrapper > .date {
  color: #2b86f6;
}

.post .bookmarks {
  margin-left: auto;
}

.comments > .post_comments_count {
  margin-left: 10px;
}
</style>
