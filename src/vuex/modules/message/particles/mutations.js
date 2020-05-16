export default {
    SET_WS: (state, ws) => {
        state.ws = ws;
    },
    ADD_TO_UNREAD: (state, message) => {
        state.unread.push(message);
    },
}