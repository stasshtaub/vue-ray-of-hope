import mutations from './particles/mutations'
import actions from './particles/actions'
import getters from './particles/getters'

export default {
    state: {
        token: localStorage.getItem("user-token") || null,
        status: null,
        profile: null
    },
    mutations,
    actions,
    getters
};