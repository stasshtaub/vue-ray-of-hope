export default {
    SET_WS: (state, ws) => {
        state.ws = ws;
    },
    ADD_TO_UNREAD: (state, message) => {
        state.unread.push(message);
    },
    REMOVE_FROM_UNREAD: (state, message) => {
        let index = state.unread.indexOf(message);
        if (index !== -1) {
            state.unread.splice(index, 1)
        }
    },
}