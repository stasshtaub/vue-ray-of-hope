<template>
  <div class="event-content">
    <textbox
      v-model="location"
      :placeholder="'Место'"
      :width="'100%'"
      @input="$emit('changeEvent', {property: 'location', value: location})"
    />
    <div class="event-dates">
      <datepicker
        v-model="startDate"
        name="start-date"
        :placeholder="'Дата начала'"
        :language="ru"
        @input="$emit('changeEvent', {property: 'startDate', value: startDate})"
      ></datepicker>
      <datepicker
        v-model="endDate"
        name="end-date"
        :placeholder="'Дата завершения'"
        :language="ru"
        @input="$emit('changeEvent', {property: 'endDate', value: endDate})"
      ></datepicker>
    </div>
  </div>
</template>

<script>
import { ru } from "vuejs-datepicker/dist/locale";
export default {
  name: "event-content",
  components: {
    datepicker: () => import("vuejs-datepicker"),
    textbox: () => import("./textbox")
  },
  props: {
    location: {
      type: String,
      default: ""
    },
    startDate: {
      type: Date,
      default: null
    },
    endDate: {
      type: Date,
      default: null
    }
  },
  data: () => ({
    ru: ru
  })
};
</script>

<style>
.event-content > .event-dates {
  margin-top: 20px;
}
.event-content > .event-dates > *:not(:last-of-type) {
  margin-right: 20px;
}
input[name="start-date"],
input[name="end-date"] {
  padding: 8px 12px;
  border-radius: 12px;
  border: 1px solid #d9d9d9;
  cursor: pointer;
}
.vdp-datepicker {
  display: inline-block;
}
.vdp-datepicker__calendar {
  border-radius: 12px;
  padding: 15px;
  top: calc(100% + 10px);
  transform: translateX(-50%);
  left: 50%;
}
</style>
