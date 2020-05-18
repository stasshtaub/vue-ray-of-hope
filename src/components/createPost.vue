<template>
  <div class="create-post frame">
    <header>
      <p>Новая запись</p>
      <delete-icon @click="$emit('close')" />
    </header>
    <section>
      <div class="sidebar">
        <ul>
          <li>Нужда</li>
          <li>Мероприятие</li>
          <li>Событие</li>
        </ul>
      </div>
      <div class="rightside">
        <note-content v-model="text" :images="images" />
        <div class="controls">
          <attach-img-icon />
          <button>Отправить</button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: "create-post",
  components: {
    noteContent: () => import("./noteContent"),
    attachImgIcon: () => import("./svg/attachImgIcon"),
    deleteIcon: () => import("./svg/deleteIcon")
  },
  data: () => ({
    type: "note",
    text: "",
    images: [],
    event: {
      location: "",
      start: {
        date: null,
        time: null
      },
      end: {
        date: null,
        time: null
      }
    },
    need: {
      needCount: 0,
      collectedCount: 0
    }
  })
};
</script>

<style>
.create-post {
  position: fixed;
  width: calc(1000px - 45px * 2);
  padding: 45px;
  min-height: 400px;
}
.create-post header {
  width: 100%;
  display: flex;
  justify-content: space-between;
}
.create-post section {
  display: grid;
  margin-top: 40px;
  grid-gap: 20px;
  grid-template-columns: 22.0833333% 76.25%;
}

.create-post .sidebar > ul {
  list-style-type: none;
}
</style>