<template>
  <div class="custom-select">
    <div class="select-wrapper">
      <div class="selected-view" @click="open=!open">
        <p :class="{'black':!selected}">{{open?placeholder:(selected?selected.name:placeholder)}}</p>
        <div class="icon-wrapper">
          <arrow-down-icon />
        </div>
      </div>
      <ul class="dropdown" v-if="options.length && open">
        <li
          v-for="option in options"
          :key="option.name"
          :class="{'selected':selected==option}"
          @click="select(option)"
        >
          <p>{{option.name}}</p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "custom-select",
  props: {
    placeholder: {
      type: String,
      default: "placeholder..."
    },
    options: {
      type: Array,
      default: () => []
    }
  },
  components: {
    arrowDownIcon: () => import("./svg/arrowDownIcon")
  },
  data: () => ({
    selected: null,
    open: false
  }),
  methods: {
    select(val) {
      this.selected = val;
      this.$emit("change", this.selected);
      this.open = false;
    }
  }
};
</script>

<style>
.custom-select {
  position: relative;
  height: calc(1.3125rem + 18px);
}
.select-wrapper {
  position: absolute;
  padding: 8px 12px;
  border-radius: 12px;
  border: 1px solid #d9d9d9;
  z-index: 1;
  background-color: white;
  width: calc(100% - 24px);
}
.custom-select .selected-view {
  position: relative;
  cursor: pointer;
}
.custom-select .selected-view > p {
  color: #a1a1a1;
}
.custom-select .selected-view > p.black {
  color: black;
}
.icon-wrapper {
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
}
.dropdown {
  list-style-type: none;
}
.custom-select .dropdown > li {
  cursor: pointer;
  margin-top: 10px;
  color: #a1a1a1;
}
.custom-select .dropdown > li.selected > p {
  color: black;
}
</style>