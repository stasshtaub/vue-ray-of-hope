import Vue from 'vue'
import Router from 'vue-router'
import store from '../vuex/store'

import homeView from '../views/homeView'
import feedView from '../views/feedView'


Vue.use(Router);

let router = new Router({
    mode: 'history',
    routes: [{
        path: '/',
        component: () => store.getters.IS_AUTHENTICATED ?
            feedView : homeView
    }, {
        path: '/messages',
        component: () =>
            import ('../views/messagesView'),
        meta: {
            requiresAuth: true
        },
    }, {
        path: '/messages/:fromId',
        component: () =>
            import ('../components/dialog'),
        meta: {
            requiresAuth: true
        },
        props: true
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
        path: '/feed',
        component: feedView,
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