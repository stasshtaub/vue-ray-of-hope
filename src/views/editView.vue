<template>
  <div class="edit-view frame" v-if="PROFILE">
    <div class="info">
      <div class="avatar-name-activity">
        <div class="avatar-wrapper">
          <avatar :img="previewAvatar || editedProfile.avatar" :size="120" />
          <label class="uploadPhoto">
            <camera-icon />
            <input type="file" @input="avatarInput" />
          </label>
        </div>

        <div class="name-activity">
          <textbox
            :name="'Название'"
            :placeholder="'Введите название...'"
            v-model="editedProfile.name"
          />
          <custom-select
            :placeholder="'Вид деятельности...'"
            :options="[{ name: 'Животные' }, { name: 'Дети' }]"
            @change="
              (activity) => {
                editedProfile.activity = activity.name;
              }
            "
          />
        </div>
      </div>
      <textbox
        v-model="editedProfile.description"
        :type="'textarea'"
        :name="'Описание'"
        :placeholder="'Введите описание...'"
      />
      <textbox
        v-model="editedProfile.phone"
        :name="'Телефон'"
        :placeholder="'Введите номер телефона...'"
      />
      <city-list-textbox
        :cityList="cityList"
        :name="'Адрес'"
        :placeholder="'Введите адрес...'"
        @input="requestCityList"
        @change="(city) => (editedProfile.city = city.id)"
      />
      <div class="buttons">
        <button class="fill" @click="editRequest">Сохранить</button>
      </div>
    </div>
    <div class="docs">
      <div class="imput-title-docs">Документы</div>
      <profile-doc-list :docs="editedProfile.docs" :canUpload="true" @addDoc="docInput" />
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Axios from "axios";

export default {
  name: "edit-view",
  data: () => ({
    editedProfile: {},
    previewAvatar: null,
    cityList: []
  }),
  components: {
    avatar: () => import("../components/avatar"),
    profileDocList: () => import("../components/profileDocList"),
    textbox: () => import("../components/textbox"),
    customSelect: () => import("../components/custom-select"),
    cityListTextbox: () => import("../components/cityListTextbox"),

    cameraIcon: () => import("../components/svg/cameraIcon")
  },
  computed: {
    ...mapGetters(["PROFILE"])
  },
  mounted() {
    this.editedProfile = Object.assign({}, this.PROFILE);
  },
  methods: {
    ...mapActions(["EDIT_PROFILE"]),
    requestCityList(text) {
      Axios.get("/api/city?search=" + text)
        .then(resp => {
          this.cityList = resp.data.cityList;
        })
        .catch(err => {
          console.log(err.message);
        });
    },
    docInput(e) {
      var files = e.target.files;
      files.forEach(file => this.previewDOC(file));
    },
    avatarInput(e) {
      let file = e.target.files[0];
      this.editedProfile.avatar = file;
      this.previewAvatar = URL.createObjectURL(file);
    },
    previewDOC(file) {
      let data = new FormData();
      data.append("doc", file);
      Axios.post("/api/convert", data, {
        headers: {
          "Content-Type": "multipart/form-data"
        },
        responseType: "blob"
      })
        .then(resp => {
          let reader = new FileReader();
          reader.onloadend = () => {
            this.editedProfile.docs.push({
              url: URL.createObjectURL(file),
              preview: reader.result
            });
          };
          reader.readAsDataURL(resp.data);
        })
        .catch(err => {
          console.log(err.message);
        });
    },
    editRequest() {
      let requestData = {};
      for (let key in this.editedProfile) {
        if (this.editedProfile[key] !== this.PROFILE[key]) {
          requestData[key] = this.editedProfile[key];
        }
      }
      if (Object.keys(requestData).length) {
        this.EDIT_PROFILE(requestData)
          .then(() => {
            alert("Профиль сохранён");
          })
          .catch(err => {
            console.log(err);
          });
      }
    }
  }
};
</script>

<style>
.edit-view {
  padding: 30px 45px;
  display: flex;
  flex-wrap: wrap;
}
.info {
  width: calc(100% - 390px - 45px);
  min-width: 475px;
  margin-right: 45px;
}
.avatar-wrapper {
  position: relative;
  display: inline-block;
}
.uploadPhoto > input {
  display: none;
}
label.uploadPhoto {
  cursor: pointer;
  position: absolute;
  right: -5px;
  bottom: -5px;
}

.avatar-name-activity {
  display: flex;
}
.edit-view .name-activity {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin-left: 20px;
}
.name-activity > *:first-of-type {
  margin-bottom: 20px;
}
.edit-view .info > *:not(:last-of-type) {
  margin-bottom: 20px;
}
.edit-view .buttons > *:not(:last-of-type) {
  margin-right: 10px;
}
.imput-title-docs {
  text-align: center;
  margin-bottom: 20px;
  color: #a1a1a1;
}
</style>
