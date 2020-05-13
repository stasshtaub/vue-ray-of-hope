import Vue from 'vue'
import Router from 'vue-router'
import store from '../vuex/store'

Vue.use(Router);

let router = new Router({
    mode: 'history',
    routes: [{
        path: '/',
        component: () => store.getters.IS_AUTHENTICATED ?
            import ('../views/feedView') : import ('../views/homeView'),
    }, {
        path: '/messages',
        component: () =>
            import ('../views/messagesView'),
        children: [{
            path: '/',
            component: () =>
                import ("../components/dialogsList"),
        }, {
            path: ':fromId',
            component: () =>
                import ("../components/dialog"),
            props: true
        }],
        meta: {
            requiresAuth: true
        },
    }, {
        path: '/edit',
        component: () =>
            import ('../views/editView'),
        meta: {
            requiresAuth: true
        },
    }, {
        path: '/signup',
        component: () =>
            import ('../views/formView'),
        children: [{
            path: 'organization',
            component: () =>
                import ('../components/signupFormOrg'),
        }],
        meta: {
            guest: true
        }
    }, {
        path: '/login',
        component: () =>
            import ('../views/formView'),
        children: [{
            path: 'organization',
            component: () =>
                import ('../components/loginFormOrg'),
        }],
        meta: {
            guest: true
        }
    }, {
        path: '/feed',
        component: import ('../views/feedView'),
        meta: {
            requiresAuth: true
        }
    }, {
        path: '/organizations',
        component: () =>
            import ('../views/organizationsView'),
        children: [{
            path: '/',
            component: () =>
                import ("../components/organizationsList")
        }, {
            path: ':id',
            component: () =>
                import ("../views/profileView")
        }],
        meta: {
            requiresAuth: true
        }
    }]
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.IS_AUTHENTICATED) {
            next()
        } else {
            next('/')
        }
    } else if (to.matched.some(record => record.meta.guest)) {
        if (!store.getters.IS_AUTHENTICATED) {
            next()
        } else {
            next('/')
        }
    } else {
        next()
    }
})

export default router