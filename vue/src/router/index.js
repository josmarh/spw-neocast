import { createRouter, createWebHistory } from 'vue-router'
import AppLayout from '../components/AppLayout.vue'
import GuestLayout from '../components/GuestLayout.vue'
import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'
import ForgetPassword from '../views/auth/ForgetPassword.vue'
import Profile from '../views/auth/UserProfile.vue'
import Channels from '../views/channels/index.vue'
import Channel from '../views/channels/create.vue'
import Looped from '../views/channels/looped.vue'
import Scheduled from '../views/channels/scheduled.vue'
import Ondemand from '../views/channels/ondemand.vue'
import EditChannel from '../views/channels/edit.vue'
import EmbedChannel from '../views/channels/embed-channel.vue'
import ShareChannel from '../views/channels/share-channel.vue'
import Videos from '../views/videos/index.vue'
import ShareVideo from '../views/videos/external-video.vue'
import EmbedVideo from '../views/videos/embeded-video.vue'
import Uploads from '../views/uploads/index.vue'
import LiveStream from '../views/livestream/index.vue'
import Website from '../views/websites/index.vue'
import EditWebsite from '../views/websites/edit.vue'
import CreateWebsite from '../views/websites/create.vue'
import WebPage from '../views/websites/web-page.vue'
import WebPageSingle from '../views/websites/web-page-single.vue'
import Analytics from '../views/analytics/index.vue'
import Welcome from '../views/Welcome.vue'
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
        redirect: '/welcome',
        component: AppLayout,
        meta: {requiresAuth: true},
        children: [
            {path: '/user/profile', name: 'Profile', component: Profile},
            {path: '/channels', name: 'Channels', component: Channels},
            {path: '/create-channel', name: 'CreateChannel', component: Channel},
            {path: '/create-channel/looped', name: 'Looped', component: Looped},
            {path: '/create-channel/scheduled', name: 'Scheduled', component: Scheduled},
            {path: '/create-channel/ondemand', name: 'Ondemand', component: Ondemand},
            {path: '/edit-channel/:hash', name: 'EditChannel', component: EditChannel},
            {path: '/contents', name: 'Videos', component: Videos},
            {path: '/uploads', name: 'Uploads', component: Uploads},
            {path: '/livestream', name: 'LiveStream', component: LiveStream},
            {path: '/website', name: 'Website', component: Website},
            {path: '/website/new', name: 'CreateWebsite', component: CreateWebsite},
            {path: '/website/:whash', name: 'EditWebsite', component: EditWebsite},
            {path: '/analytics', name: 'Analytics', component: Analytics},
            {path: '/welcome', name: 'Welcome', component: Welcome},
        ] 
    },
    { path: '/watch/video/:str', name: 'ShareVideo', component: ShareVideo },
    { path: '/embed/video/:str', name: 'EmbedVideo', component: EmbedVideo },
    { path: '/embed/channel/:str', name: 'EmbedChannel', component: EmbedChannel },
    { path: '/watch/channel/:str', name: 'ShareChannel', component: ShareChannel },
    { path: '/w/:str', name: 'WebPage', component: WebPage },
    { path: '/w/:str/channel/:chash', name: 'WebPageSingle', component: WebPageSingle },
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
        next({name: 'Welcome'})
    }else {
        next();
    }
})

export default router;