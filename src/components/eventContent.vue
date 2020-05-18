<template>
  <div class="event-content">
    <datepicker
      v-model="startDate"
      name="start-date"
      :placeholder="'Дата начала'"
      :language="ru"
      @input="$emit('changeStartDate', startDate)"
    ></datepicker>
    <datepicker
      v-model="endDate"
      name="end-date"
      :placeholder="'Дата завершения'"
      :language="ru"
      @input="$emit('changeEndDate', endDate)"
    ></datepicker>
  </div>
</template>

<script>
import { ru } from "vuejs-datepicker/dist/locale";
export default {
  name: "event-content",
  components: {
    datepicker: () => import("vuejs-datepicker"),
  },
  props: {
    startDate: {
      type: Date,
      default: null,
    },
    endDate: {
      type: Date,
      default: null,
    },
  },
  data: () => ({
    ru: ru,
  }),
};
</script>

<style>
.event-content > *:not(:last-of-type) {
  margin-right: 20px;
}
input[name="start-date"],
input[name="end-date"] {
  border-radius: 10px;
  border: 1px solid #b5b5b5;
  padding: 5px 10px;
  cursor: pointer;
}
.vdp-datepicker {
  display: inline-block;
}
.vdp-datepicker__calendar {
  border-radius: 10px;
  padding: 15px;
  top: calc(100% + 10px);
  transform: translateX(-50%);
  left: 50%;
}
</style>
