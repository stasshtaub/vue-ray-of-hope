import axios from "axios"

export default {
    async EDIT_PROFILE({ commit, dispatch }, profileData) {
        commit("EDIT_PROFILE");

        const formData = new FormData();
        for (let key in profileData) {
            formData.append(key, profileData[key]);
        }

        return new Promise((resolve, reject) => {
            axios.post('/api/edit', formData)
                .then(resp => {
                    dispatch("PROFILE_REQUEST", resp.data.id);
                    resolve(resp);
                })
                .catch(err => {
                    commit("ERROR", err);
                    reject(err);
                })
        });
    },
    async DELETE_POST({ commit, state }, post) {
        commit("DELETE_POST");
        return new Promise((resolve, reject) => {
            axios.delete(`/api/organizations/${state.profile.id}/posts/${post.id}`)
                .then(resp => {
                    commit("DELETE_POST_SUCCESS");
                    resolve(resp)
                })
                .catch(err => {
                    commit("ERROR", err);
                    reject(err);
                })
        });
    },
    async ORG_SIGNUP_REQUEST({ commit }, { email, inn, password, confirmPassword, name }) {
        return await new Promise((resolve, reject) => {
            commit("ORG_SIGNUP_REQUEST");
            var data = new FormData();
            data.append("email", email);
            data.append("inn", inn);
            data.append("password", password);
            data.append("confirmPassword", confirmPassword);
            data.append("name", name);
            axios.post('/api/signup/organization', data)
                .then(resp => {
                    var token = resp.data.token;
                    localStorage.setItem('user-token', token);
                    axios.defaults.headers.common['Authorization'] = token;
                    commit("SIGNUP_SUCCESS", { token: token, profile: resp.data.profile });
                    resolve(resp);
                })
                .catch(err => {
                    commit("ERROR", err);
                    reject(err);
                })
        });
    },
    async LOGIN({ commit }, { emailOrInn, password }) {
        commit("LOGIN_REQUEST");
        var data = new FormData();
        data.append("emailOrInn", emailOrInn);
        data.append("password", password);
        return await new Promise((resolve, reject) => {
            axios.post('/api/login/organization', data)
                .then(resp => {
                    var token = resp.data.token;
                    localStorage.setItem('user-token', token);
                    axios.defaults.headers.common['Authorization'] = token;
                    commit("LOGIN_SUCCESS", { token: token, profile: resp.data.profile });
                    resolve(resp.data);
                })
                .catch(err => {
                    commit("AUTH_ERROR", err);
                    localStorage.removeItem('user-token');
                    reject(err);
                })
        });
    },
    async LOGIN_WITH_TOKEN({ commit }) {
        commit("LOGIN_REQUEST");
        return await new Promise((resolve, reject) => {
            axios.post('/api/login/organization')
                .then(resp => {
                    commit("LOGIN_WITH_TOKEN_SUCCESS", resp.data.profile);
                    resolve(resp);
                })
                .catch(err => {
                    commit("AUTH_ERROR", err);
                    localStorage.removeItem('user-token');
                    reject(err);
                })
        });
    },
    AUTH_LOGOUT: ({ commit }) => {
        return new Promise((resolve) => {
            commit("AUTH_LOGOUT");
            localStorage.removeItem('user-token');
            delete axios.defaults.headers.common['Authorization'];
            resolve();
        })
    },
    async PROFILE_REQUEST({ commit, dispatch }, id) {
        return await new Promise(() => {
            axios.get('/api/organizations/' + id)
                .then(resp => {
                    commit("SET_PROFILE", resp.data.profile);
                })
                .catch(error => {
                    commit("ERROR", error.message);
                    dispatch("AUTH_LOGOUT");
                })
        });
    },
}