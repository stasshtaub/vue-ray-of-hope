import actions from './particles/actions'
import mutations from './particles/mutations'
import getters from './particles/getters'

export default {
    state: {
        ws: null,
        unread: []
    },
    actions,
    mutations,
    getters
};