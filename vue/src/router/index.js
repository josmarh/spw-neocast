import { createRouter, createWebHistory } from 'vue-router'
import AppLayout from '../components/AppLayout.vue'
import GuestLayout from '../components/GuestLayout.vue'
import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'
import ForgetPassword from '../views/auth/ForgetPassword.vue'
import Dashboard from '../views/Dashboard.vue'
import Profile from '../views/auth/UserProfile.vue'
import Channels from '../views/channels/index.vue'
import Channel from '../views/channels/create.vue'
import Looped from '../views/channels/looped.vue'
import Scheduled from '../views/channels/scheduled.vue'
import Ondemand from '../views/channels/ondemand.vue'
import Videos from '../views/videos/index.vue'
import ShareVideo from '../views/videos/external-video.vue'
import EmbedVideo from '../views/videos/embeded-video.vue'
import Uploads from '../views/uploads/index.vue'
import LiveStream from '../views/livestream/index.vue'
import Website from '../views/websites/index.vue'
import Analytics from '../views/analytics/index.vue'
import store from "../store"

const routes = [
    {
        path: '/auth',
        redirect: '/login',
        name: 'Auth',
        component: GuestLayout,
        meta: {isGuest: true},
        children: [
            { path: '/login', name: 'Login', component: Login },
            { path: '/register', name: 'Register', component: Register },
            { path: '/forgot-password', name: 'ForgetPassword', component: ForgetPassword },
        ]
    },
    {
        path: '/',
        redirect: '/dashboard',
        component: AppLayout,
        meta: {requiresAuth: true},
        children: [
            {path: '/dashboard', name: 'Dashboard', component: Dashboard},
            {path: '/user/profile', name: 'Profile', component: Profile},
            {path: '/channels', name: 'Channels', component: Channels},
            {path: '/create-channel', name: 'CreateChannel', component: Channel},
            {path: '/create-channel/looped', name: 'Looped', component: Looped},
            {path: '/create-channel/scheduled', name: 'Scheduled', component: Scheduled},
            {path: '/create-channel/ondemand', name: 'Ondemand', component: Ondemand},
            {path: '/contents', name: 'Videos', component: Videos},
            {path: '/uploads', name: 'Uploads', component: Uploads},
            {path: '/livestream', name: 'LiveStream', component: LiveStream},
            {path: '/website', name: 'Website', component: Website},
            {path: '/analytics', name: 'Analytics', component: Analytics},
        ] 
    },
    { path: '/watch/video/:str', name: 'ShareVideo', component: ShareVideo },
    { path: '/embed/video/:str', name: 'EmbedVideo', component: EmbedVideo },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

// handling user auth
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({name: 'Login'})
    } else if (store.state.user.token && to.meta.isGuest) {
        next({name: 'Dashboard'})
    }else {
        next();
    }
})

export default router;