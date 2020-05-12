export default {
    EDIT_PROFILE: state => {
        state.status = "loading";
    },
    DELETE_POST: state => {
        state.status = "loading";
    },
    DELETE_POST_SUCCESS: state => {
        state.status = "success";
    },
    ORG_SIGNUP_REQUEST: state => {
        state.status = "loading";
    },
    SIGNUP_SUCCESS: (state, { token, profile }) => {
        state.status = "success";
        state.token = token;
        state.profile = profile;
    },

    LOGIN_REQUEST: state => {
        state.status = "loading";
    },
    LOGIN_SUCCESS: (state, { token, profile }) => {
        state.status = "success";
        state.token = token;
        state.profile = profile;
    },
    LOGIN_WITH_TOKEN_SUCCESS: (state, profile) => {
        state.status = "success";
        state.profile = profile;
    },
    AUTH_ERROR: (state, error) => {
        state.status = error;
        state.token = null;
        state.profile = null;
    },
    ERROR: (state, error) => {
        state.status = error;
    },
    AUTH_LOGOUT: state => {
        state.token = null;
        state.profile = null;
    },
    SET_PROFILE: (state, profile) => {
        state.status = "success";
        state.profile = profile;
    },
    PROFILE_ERROR: (state, error) => {
        state.token = null;
        state.profile = null;
        state.status = error;
    }
}