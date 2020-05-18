<template>
  <div class="mask">
    <div class="create-post frame">
      <header>
        <p>Новая запись</p>
        <button class="icon" @click="$emit('close')">
          <delete-icon />
        </button>
      </header>
      <section>
        <div class="sidebar">
          <switch-posts @changeType="changeType" :withAll="false" />
        </div>
        <div class="rightside">
          <note-content v-model="text" :images="images" />
          <event-content
            v-if="type == 'event'"
            :startDate="event.startDate"
            :endDate="event.endDate"
            @changeStartDate="changeStartDate"
            @changeEndDate="changeEndDate"
          />
          <need-content
            v-if="type == 'need'"
            :needCount="need.needCount"
            :collectedCount="need.collectedCount"
            @changeNeedCount="changeNeedCount"
            @changeCollectedCount="changeCollectedCount"
          />
          <div class="controls">
            <label class="uploadImages">
              <attach-img-icon />
              <input type="file" multiple @input="inputImages" />
            </label>
            <button class="link">Отправить</button>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: "create-post",
  components: {
    switchPosts: () => import("./switchPosts"),

    noteContent: () => import("./noteContent"),
    eventContent: () => import("./eventContent"),
    needContent: () => import("./needContent"),

    attachImgIcon: () => import("./svg/attachImgIcon"),
    deleteIcon: () => import("./svg/deleteIcon"),
  },
  data: () => ({
    type: "note",
    text: "",
    images: [],
    event: {
      location: "",
      startDate: null,
      endDate: null,
    },
    need: {
      needCount: null,
      collectedCount: null,
    },
  }),
  methods: {
    inputImages(e) {
      let files = e.target.files;
      files.forEach((file) => {
        var reader = new FileReader();

        reader.onloadend = () => {
          this.images.push({ url: reader.result });
        };

        reader.readAsDataURL(file);
      });
    },
    changeType(type) {
      this.type = type;
    },
    changeStartDate(date) {
      this.event.startDate = date;
    },
    changeEndDate(date) {
      this.event.endDate = date;
    },
    changeNeedCount(count) {
      this.need.needCount = count;
    },
    changeCollectedCount(count) {
      this.need.collectedCount = count;
    },
  },
  created() {
    document
      .querySelector(".user-layout .container.outer")
      .setAttribute("style", "overflow: hidden; height:calc(100vh - 120px);");
  },
  beforeDestroy() {
    document
      .querySelector(".user-layout .container.outer")
      .setAttribute("style", "");
  },
};
</script>

<style>
.mask {
  z-index: 99999;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
}
.create-post {
  margin: 90px auto 0 auto;
  width: 910px;
  padding: 45px;
  display: flex;
  flex-direction: column;
}
.create-post header {
  position: relative;
  width: 100%;
  display: flex;
  justify-content: center;
}
.create-post header button {
  position: absolute;
  right: 0;
  line-height: 0;
}
.create-post section {
  margin-top: 40px;
  display: grid;
  grid-gap: 20px;
  grid-template-columns: calc(22.0833333% - 10px) 1fr;
}
.create-post .rightside {
  display: flex;
  flex-direction: column;
}
.create-post .rightside > *:not(:last-of-type) {
  margin-bottom: 20px;
}
.create-post .controls {
  margin-top: auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.create-post .sidebar {
  display: grid;
  grid-gap: 15px;
}
.create-post .sidebar label.selected {
  font-family: SegoeSB;
  color: #848484;
}
.create-post .uploadImages {
  cursor: pointer;
}
.create-post .uploadImages > input {
  display: none;
}
</style>
