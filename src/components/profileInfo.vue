<template>
  <div class="profile-info frame">
    <div class="info">
      <div class="avatar-name-activity">
        <avatar :img="userData.avatar" :size="120" />

        <div class="name-activity">
          <h1 class="name">{{userData.name}}</h1>
          <div class="activity wrp" v-if="userData.activity">
            <heart-icon />
            <span>{{userData.activity}}</span>
          </div>
        </div>
      </div>

      <div class="description-contacts-buttons">
        <description-limited v-if="userData.description" :text="userData.description" />

        <div class="contacts" v-if="userData.phone || userData.city">
          <p class="title">Контакты:</p>
          <div class="wrp" v-if="userData.city">
            <location-icon />
            <span class="home-city">{{userData.region+", "+userData.city}}</span>
          </div>
          <div class="wrp" v-if="userData.phone">
            <phone-icon />
            <span>{{userData.phone}}</span>
          </div>
        </div>

        <div class="buttons">
          <router-link v-if="isSelf" to="/edit" class="wrp">
            <pen-icon />
            <span>Редактировать профиль</span>
          </router-link>

          <template v-else>
            <button class="fill">
              <heart-icon />
              <span>В любимые</span>
            </button>
            <button class="fill">
              <img class="mess-icon" src="/assets/img/mess_icon.png " />
              <span>Написать</span>
            </button>
            <button class="fill">
              <span>Пожертовать</span>
            </button>
          </template>
        </div>
      </div>
    </div>

    <profile-doc-list :docs="userData.docs" :limit="6" />
  </div>
</template>

<script>
export default {
  name: "profile-info",
  props: {
    isSelf: {
      type: Boolean,
      default: false
    },
    userData: {
      type: Object,
      default: () => ({
        name: null,
        avatar: null,
        description: null,
        activity: null,
        city: null,
        phone: null,
        docs: []
      })
    }
  },
  components: {
    avatar: () => import("./avatar"),
    profileDocList: () => import("./profileDocList"),
    descriptionLimited: () => import("./description-limited"),

    locationIcon: () => import("./svg/locationIcon"),
    heartIcon: () => import("./svg/heartIcon"),
    phoneIcon: () => import("./svg/phoneIcon"),
    penIcon: () => import("./svg/penIcon")
  }
};
</script>

<style>
.profile-info {
  padding: 30px 45px;
  display: flex;
  flex-wrap: wrap;
}
.profile-info .info {
  width: calc(100% - 435px);
  min-width: 475px;
  margin-right: 45px;
}
.heart {
  fill: #bfbfbf;
}
.avatar-name-activity {
  display: flex;
}

.profile-info .name-activity {
  margin-left: 25px;
}

.profile-info .name-activity,
.activity {
  margin-top: 10px;
}

.wrp {
  display: flex;
  align-items: center;
}
.wrp > span {
  margin-left: 10px;
}

.description-contacts-buttons {
  margin-top: 20px;
  display: grid;
  grid-gap: 15px;
}
.profile-info .description > .text,
.profile-info .contacts span,
.activity span {
  color: #a1a1a1;
}

.profile-info .title {
  margin-bottom: 5px;
}

.contacts > .wrp:not(:last-of-type) {
  margin-bottom: 5px;
}
.profile-info .buttons>*:not(:last-of-type) {
    margin-right: 10px;
}
</style>