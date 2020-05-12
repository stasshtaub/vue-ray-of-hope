<template>
  <div class="profile-doc-list">
    <ul class="doc-list">
      <label class="add-doc" v-if="canUpload">
        <plus-icon />
        <input type="file" multiple @input="$emit('addDoc', $event)" />
      </label>
      <li class="doc" v-for="doc in limited" :key="doc.id">
        <a :href="doc.url">
          <img :src="doc.preview" alt="doc-preview" />
        </a>
      </li>
    </ul>
    <button
      v-if="limit && docs.length>limit"
      @click="showAll=!showAll"
    >{{showAll?"Скрыть":`Все документы (${docs.length})`}}</button>
  </div>
</template>

<script>
export default {
  name: "profile-doc-list",
  props: {
    docs: {
      type: Array,
      default: () => []
    },
    limit: {
      type: Int8Array,
      default: null
    },
    canUpload: {
      type: Boolean,
      default: false
    }
  },
  components: {
    plusIcon: () => import("./svg/plusIcon")
  },
  computed: {
    limited() {
      return !this.limit || this.showAll
        ? this.docs
        : this.docs.slice(0, this.limit);
    }
  }
};
</script>

<style>
.profile-doc-list {
  display: inline-block;
}
.doc-list {
  display: grid;
  grid-template-columns: repeat(3, 120px);
  grid-template-rows: repeat(auto-fit, 150px);
  grid-gap: 15px;
}
.doc-list > * {
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 3px 6px #00000014;
  border-radius: 10px;
  overflow: hidden;
  height: 150px;
}
.doc-list > .doc > a {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
}
.doc-list > .doc > a > img {
  max-width: 100%;
  max-height: 100%;
}
.profile-doc-list button {
  border: none;
  background: none;
  margin-top: 15px;
  margin-left: auto;
  margin-right: auto;
  display: block;
  color: #bfbfbf;
  font: unset;
}
.add-doc{
  cursor: pointer;
}
.add-doc > input {
  display: none;
}
</style>