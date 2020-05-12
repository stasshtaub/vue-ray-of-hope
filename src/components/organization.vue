<template>
  <div class="organization frame">
    <header>
      <router-link :to="'/organizations/'+org.id">
        <avatar :img="org.avatar || undefined" :size="60" />
      </router-link>
      <div class="info">
        <router-link :to="'/organizations/'+org.id">
          <h3 class="name">{{org.name}}</h3>
        </router-link>
        <div class="activity" v-if="org.activity">
          <heart-icon />
          <span class="text">{{org.activity}}</span>
        </div>
      </div>
    </header>
    <p class="description" v-if="org.description">{{org.description.substring(0,100)+'...'}}</p>
  </div>
</template>

<script>
export default {
  name: "organization",
  props: {
    org: {
      type: Object,
      default: () => ({
        id: null,
        name: null,
        description: null,
        activity: null,
        avatar: null
      })
    }
  },
  components: {
    avatar: () => import("./avatar"),
    heartIcon: () => import("./svg/heartIcon")
  }
};
</script>

<style>
.organization {
  padding: 20px;
}
.organization > header {
  display: flex;
  align-items: center;
}
.organization .name {
  font-weight: normal;
  color: #2b86f6;
}
.organization > header > .info {
  margin-left: 15px;
  display: grid;
  grid-gap: 7px;
}
.organization .activity > .text {
  margin-left: 5px;
}
.organization > .description {
  margin-top: 15px;
}
</style>