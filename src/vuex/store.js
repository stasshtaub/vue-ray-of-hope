import Vue from 'vue'
import Vuex from 'vuex'

import userModule from './modules/user/userModule'

Vue.use(Vuex);
Vue.config.devtools = true;

let store = new Vuex.Store({
    modules: {
        userModule
    }
});

export default store;