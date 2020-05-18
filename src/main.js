import Vue from 'vue'
import router from './router/router'
import store from './vuex/store';

import App from './App.vue'

import vuescroll from 'vuescroll';
Vue.use(vuescroll);

import VueTextareaAutosize from "vue-textarea-autosize";
Vue.use(VueTextareaAutosize);

import axios from 'axios';
const token = localStorage.getItem('user-token')
if (token) {
    axios.defaults.headers.common['Authorization'] = token
}

Vue.config.productionTip = false

new Vue({
    router,
    store,
    render: (h) => h(App)
}).$mount('#app')