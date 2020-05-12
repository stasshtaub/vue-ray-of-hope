import Vue from 'vue'
import router from './router/router'
import store from './vuex/store';

import App from './App.vue'

import { VueMasonryPlugin } from 'vue-masonry';
Vue.use(VueMasonryPlugin);


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