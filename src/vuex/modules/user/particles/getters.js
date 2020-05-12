export default {
    IS_AUTHENTICATED: state => !!state.token,
    PROFILE: state => state.profile,
}