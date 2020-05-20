<template>
  <div class="switch-posts frame">
    <label v-if="withAll" class="label-all" :class="{ selected: selected == null }">
      Все записи
      <input
        name="typepost"
        type="radio"
        v-model="selected"
        :value="null"
        @change="$emit('changeType', selected)"
        checked
      />
    </label>
    <label v-for="type in types" :key="type.value" :class="{ selected: type.value == selected }">
      {{ type.name }}
      <input
        :style="{ marginLeft: withAll ? '15px' : '' }"
        name="typepost"
        type="radio"
        v-model="selected"
        :value="type.value"
        @change="$emit('changeType', selected)"
      />
    </label>
  </div>
</template>

<script>
export default {
  name: "switch-posts",
  props: {
    withAll: {
      type: Boolean,
      default: true
    }
  },
  data: () => ({
    selected: null,
    types: [
      {
        name: "Нужда",
        value: "need"
      },
      {
        name: "Мероприятие",
        value: "event"
      },
      {
        name: "Событие",
        value: "note"
      }
    ]
  }),
  mounted() {
    if (!this.withAll) {
      this.selected = this.types[0].value;
    }
  }
};
</script>

<style>
.switch-posts {
  /* padding: 30px; */
  height: fit-content;
  display: grid;
  grid-gap: 15px;
}
.switch-posts input {
  display: none;
}

.switch-posts > label {
  color: #a1a1a1;
  cursor: pointer;
}
.switch-posts > label.selected {
  font-family: SegoeSB;
  color: #848484;
}

.switch-posts > label:not(.label-all) {
  margin-left: 15px;
}
</style>
