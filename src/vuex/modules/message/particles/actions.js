export default {
    async SEND_WS_DATA({ state, dispatch }, data) {
        if (!state.ws.readyState) {
            setTimeout(() => {
                dispatch('SEND_WS_DATA', data);
            }, 100);
        } else {
            state.ws.send(JSON.stringify(data));
        }
    },
    WS_INIT({ dispatch, commit, rootGetters }, url) {
        const ws = new WebSocket(url);
        ws.onopen = () => {
            console.log("Соединение установлено!")
        };
        ws.onmessage = (e) => {
            let message = JSON.parse(e.data);
            commit('ADD_TO_UNREAD', message);
        };
        ws.onerror = (err) => {
            console.log(err);
        };
        commit("SET_WS", ws);

        dispatch("SEND_WS_DATA", { command: "connect", userId: rootGetters.PROFILE.id })
    },
}