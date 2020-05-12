<template>
  <div class="city-list-textbox">
    <div class="textbox-title">{{name}}</div>
    <input
      type="text"
      :style="{width: `calc(${width} - 24px)`}"
      :placeholder="placeholder"
      v-model="text"
      @input="$emit('input', text)"
    />
    <ul class="dropdown" v-if="cityList.length">
      <li v-for="city in cityList" :key="city.id" @click="selectCity(city)">
        <p class="city">{{city.name}}</p>
        <p class="region">{{city.region}}</p>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "city-list-textbox",
  props: {
    width: {
      type: String,
      default: "100%"
    },
    name: {
      type: String,
      default: ""
    },
    placeholder: {
      type: String,
      default: ""
    },
    cityList: {
      type: Array,
      default: () => []
    }
  },
  data: () => ({
    selected: null,
    text: ""
  }),
  methods: {
    selectCity(city) {
      this.text = `${city.region}, ${city.name}`;
      this.$emit("change", city);
      this.cityList = [];
    }
  }
};
</script>

<style>
.city-list-textbox {
  position: relative;
}
.textbox-title {
  position: absolute;
  color: #a1a1a1;
  background-color: #fff;
  font-size: 0.8rem;
  top: -10px;
  left: 9px;
  padding: 0 4px;
}
.city-list-textbox > *:not(.textbox-title) {
  padding: 8px 12px;
  border-radius: 12px;
  border: 1px solid #d9d9d9;
}
.city-list-textbox > .dropdown {
  display: grid;
  grid-gap: 8px;
  width: 100%;
}
.city-list-textbox > .dropdown > li {
  cursor: pointer;
}
.city-list-textbox > .dropdown .region {
  font-size: 0.8125rem;
}
</style>