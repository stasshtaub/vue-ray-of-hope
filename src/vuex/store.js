import Vue from 'vue'
import Vuex from 'vuex'

import userModule from './modules/user/userModule'
import messageModule from './modules/message/messageModule'

Vue.use(Vuex);
Vue.config.devtools = true;

let store = new Vuex.Store({
    modules: {
        userModule,
        messageModule
    }
});

export default store;