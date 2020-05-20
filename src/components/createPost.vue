<template>
  <div class="mask" @click.self="$emit('close')">
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
            @changeEvent="changeEvent"
          />
          <need-content
            v-if="type == 'need'"
            :needCount="need.needCount"
            :collectedCount="need.collectedCount"
            @changeNeed="changeNeed"
          />
          <div class="controls">
            <label class="uploadImages">
              <attach-img-icon />
              <input type="file" multiple @input="inputImages" />
            </label>
            <button class="link" @click="send">Отправить</button>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
  name: "create-post",
  components: {
    switchPosts: () => import("./switchPosts"),

    noteContent: () => import("./noteContent"),
    eventContent: () => import("./eventContent"),
    needContent: () => import("./needContent"),

    attachImgIcon: () => import("./svg/attachImgIcon"),
    deleteIcon: () => import("./svg/deleteIcon")
  },
  data: () => ({
    type: "note",
    text: "",
    images: [],
    uploadedFiles: [],
    event: {
      location: "",
      startDate: null,
      endDate: null
    },
    need: {
      needCount: null,
      collectedCount: null
    }
  }),
  computed: {
    ...mapGetters(["PROFILE"])
  },
  methods: {
    emitCreatedPost(id) {
      let post = {
        id: id,
        author: this.PROFILE,
        text: this.text,
        images: this.images,
        date: new Date()
      };

      switch (this.type) {
        case "need":
          post.needData = this.need;
          break;
        case "event":
          post.eventData = this.event;
          break;
      }

      this.$emit("createdPost", post);
    },
    send() {
      axios
        .post(
          `/api/organizations/${this.PROFILE.id}/posts`,
          this.generateFormData()
        )
        .then(resp => {
          this.emitCreatedPost(resp.data.id);
        })
        .catch(err => {
          console.log(err.data);
          console.log(err.message);
        });
    },
    generateFormData() {
      let fd = new FormData();
      fd.append("type", this.type);
      fd.append("text", this.text);
      this.uploadedFiles.forEach(file => {
        fd.append("images[]", file);
      });
      switch (this.type) {
        case "event":
          fd.append("location", this.event.location);
          fd.append(
            "startDate",
            "@" + Math.round(this.event.startDate.getTime() / 1000)
          );
          fd.append(
            "endDate",
            "@" + Math.round(this.event.endDate.getTime() / 1000)
          );
          break;
        case "need":
          fd.append("needCount", this.need.needCount);
          fd.append("collectedCount", this.need.collectedCount);
          break;
      }
      return fd;
    },
    inputImages(e) {
      let files = e.target.files;
      files.forEach(file => {
        this.uploadedFiles.push(file);
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
    changeEvent(data) {
      this.event[data.property] = data.value;
    },
    changeNeed(data) {
      this.need[data.property] = data.value;
    },
    changeNeedCount(count) {
      this.need.needCount = count;
    },
    changeCollectedCount(count) {
      this.need.collectedCount = count;
    }
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
  }
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
