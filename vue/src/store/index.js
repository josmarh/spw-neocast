import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: JSON.parse(localStorage.getItem('userInfo')),
            token: localStorage.getItem('TOKEN'),
            permissions: localStorage.getItem('can'),
        },
        notifyError: '',
        notifySuccess: '',
        contents: {
            data: [],
            links: {},
            meta: {}
        },
        externalContent: {},
        channels: {
            data: [],
            links: {},
            meta: {}
        },
        playlist: {
            data: [],
            links: {},
            meta: {}
        },
        websites: {
            data: [],
            links: {},
            meta: {}
        },
        liveStream: {
            data: [],
            links: {},
            meta: {}
        },
        users: {
            data: [],
            links: {},
            meta: {}
        },
        userGuard: {
            data: [],
            links: {},
            meta: {}
        },
        articles: {
            data: [],
            links: {},
            meta: {}
        }
    },
    getters: {},
    actions: {
        setSuccessNotification({commit}, message){
            commit('setSuccessNotification', message)
        },
        setErrorNotification({commit}, message){
            commit('setErrorNotification', message)
        },
        register({ commit }, user){
            return axiosClient.post('/register', user)
                .then(({data}) => {
                    // commit('setUser', data)
                    return data;
                })
        },
        login({ commit }, user){
            return axiosClient.post('/login', user)
                .then(({data}) => {
                    commit('setUser', data)
                    return data;
                })
        },
        forgotPassword({ }, user){
            return axiosClient.post('/forgot-password', user)
                .then(({data}) => {
                    return data;
                })
        },
        resetPassword({ }, user){
            return axiosClient.post('/reset-password', user)
                .then(({data}) => {
                    return data;
                })
        },
        logout({ commit }){
            return axiosClient.post('/logout')
                .then(response => {
                    commit('logout')
                    localStorage.clear();
                    return response;
                })
        },
        updatePersonalInfo({ commit }, user){
            return axiosClient.put(`/personal-info`, user)
            .then(({data}) => {
                commit('updatePersonalInfo', data)
                return data;
            })
        },
        updatePassword({ commit }, userPass){
            return axiosClient.put(`/password/update`, userPass)
                .then(({data}) => {
                    commit('updatePassword')
                    return data;
                })
        },
        uploadFiles({ commit }, files){
            return axiosClient.post(`/uploads`, files)
                .then(({data}) => {
                    return data;
                })
        }, // video content actions
        getContents({ commit }, {url = null} = {}){
            url = url || '/videos'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setContents', data)
                    return data;
                })
        },
        updateContent({ commit }, videoUpdate){
            return axiosClient.put(`/video/update`, videoUpdate)
                .then(({data}) => {
                    return data;
                })
        },
        getExternalContent({ commit }, str) {
            return axiosClient.get(`/video/show/${str}`)
                .then(({data}) => {
                    commit('getExternalContent', data)
                    return data;
                })
        },
        downloadContent({ commit }, id) {
            return axiosClient.get(`/video/download/${id}`, {responseType: 'blob'})
                .then(({data}) => {
                    return data;
                })
        },
        deleteContent({ }, id){
            return axiosClient.delete(`/video/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        searchContent({ commit }, searchParam){
            return axiosClient.get(`/videos`, { 
                    params: { 
                        name: searchParam.name,
                        tags: searchParam.tag,
                        match: searchParam.tagMatch,
                        type: searchParam.mediaType
                    } 
                })
                .then(({data}) => {
                    commit('setContents', data)
                    return data;
                })
        },
        addExternalContent({ commit }, externalLink){
            return axiosClient.post('/video/external', externalLink)
            .then(({data}) => {
                return data;
            })
        },
        queryContentLink({ commit }, externalLink){
            return axiosClient.get(externalLink)
            .then(({data}) => {
                return data;
            })
        },  // channels section actions
        getChannelList({ commit }, {url = null} = {}){
            url = url || '/channels'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setChannels', data)
                    return data;
                })
        },
        storeChannel({ }, model){
            return axiosClient.post('/channel/store', model)
            .then(({data}) => {
                return data;
            })
        },
        filterChannel({ commit }, name){
            return axiosClient.get(`/channels`, { 
                params: {name: name}
            })
            .then(({data}) => {
                commit('setChannels', data)
                return data;
            })
        },
        editChannel({ commit }, hash){
            return axiosClient.get(`/channel/edit/${hash}`)
                .then(({data}) => {
                    return data;
                })
        },
        updateChannel({}, data){
            return axiosClient.put(`/channel/update/${data.id}`, data)
                .then(({data}) => {
                    return data;
                })
        },
        deleteChannel({}, id){
            return axiosClient.delete(`/channel/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        externalChannel({ commit }, hash){
            return axiosClient.get(`/channel/info/${hash}`)
                .then(({data}) => {
                    return data;
                })
        },
        rokuChannel({ commit }, chash){
            return axiosClient.get(`/channel/w/${chash}`, {
                params: {format: 'roku_json'}
            })
                .then(({data}) => {
                    return data;
                })
        },
        getVideos({ commit }, chash){
            return axiosClient.get(`/channel/videos/${chash.chash}`)
            .then(({data}) => {
                commit('setContents', data)
                return data;
            })
        },
        getVideosPage({ commit }, {url = null} = {}){
            return axiosClient.get(url)
            .then(({data}) => {
                commit('setContents', data)
                return data;
            })
        },
        addToPlaylist({ commit }, videos){
            return axiosClient.post(`/channel/videos`, videos)
            .then(({data}) => {
                // commit('setChannels', data)
                return data;
            })
        },
        getPlaylist({ commit }, channelId){
            return axiosClient.get(`/channel/playlist/${channelId}`)
            .then(({data}) => {
                commit('setPlaylist', data)
                return data;
            })
        },
        getPlaylistPage({ commit }, {url = null} = {}){
            return axiosClient.get(url)
            .then(({data}) => {
                commit('setPlaylist', data)
                return data;
            })
        },
        deletePlistVideo({ }, vId){
            return axiosClient.delete(`/channel/playlist/delete/${vId}`)
            .then(({data}) => {
                return data;
            })
        },
        duplicateChannel({ }, payload){
            return axiosClient.post(`/channel/duplicate`, payload)
            .then(({data}) => {
                return data;
            })
        },
        getChannelEmbedPlayerList({ commit }, chash){
            return axiosClient.get(`/channel/show/${chash}`)
            .then(({data}) => {
                return data;
            })
        },
        sendVideoViews({ }, payload){
            return axiosClient.put(`/channel/video/track-views/${payload.chash}`, {
                    videoUrl: payload.videoUrl
                })
            .then(({data}) => {
                return data;
            })
        },
        getVideoTitle({ }, tempName){
            return axiosClient.get(`/video/info?video=${tempName}`)
                .then(({data}) => {
                    return data;
                })
        },
        getWebsites({ commit }, {url = null} = {}){
            url = url || '/websites'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setWebsites', data)
                    return data;
                })
        },
        createWebsite({  }, payload){
            return axiosClient.post(`/website/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        editWebsite({ }, whash){
            return axiosClient.get(`/website/edit/${whash}`)
                .then(({data}) => {
                    return data;
                })
        },
        updateWebsite({ }, payload){
            return axiosClient.put(`/website/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteWebsite({ }, id){
            return axiosClient.delete(`/website/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        filterWebsite({ commit }, params){
            return axiosClient.get(`/websites?name=${params}`)
                .then(({data}) => {
                    commit('setWebsites', data)
                    return data;
                })
        },
        getWebsiteContent({ }, params){
            return axiosClient.get(`/website/content/${params}`)
                .then(({data}) => {
                    return data;
                })
        },
        getWebsitePlaylist({ commit }, channelId){
            return axiosClient.get(`channel/show/${channelId}`)
            .then(({data}) => {
                commit('setPlaylist', data)
                return data;
            })
        },
        getWebsiteChannels({ }, whash){
            return axiosClient.get(`website/channels/${whash}`)
            .then(({data}) => {
                return data;
            })
        },
        getCardReport({ }){
            return axiosClient.get(`report/card`)
                .then(({data}) => {
                    return data;
                })
        },
        getChartReport({ }, queryParams){
            return axiosClient.get(`report/chart`, {
                params: {
                    chash: queryParams.chash.channel_hash,
                    period: queryParams.period.val
                }
            })
                .then(({data}) => {
                    return data;
                })
        },
        liveStreams({ commit }, {url = null} = {}){
            url = url || '/livestreams'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setliveStreams', data)
                    return data;
                })
        },
        liveStreamFilter({ commit }, params){
            return axiosClient.get(`/livestreams?title=${params}`)
                .then(({data}) => {
                    commit('setliveStreams', data)
                    return data;
                })
        },
        liveStreamCreate({  }, payload){
            return axiosClient.post(`/livestream/create`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        liveStreamEdit({ }, lhash){
            return axiosClient.get(`/livestream/edit/${lhash}`)
                .then(({data}) => {
                    return data;
                })
        },
        liveStreamUpdate({ }, payload){
            return axiosClient.put(`/livestream/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        liveStreamDelete({ }, id){
            return axiosClient.delete(`/livestream/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        liveStreamVideo({ }, payload){
            return axiosClient.post(`/livestream/store/live`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        liveStreamWatch({ }, lhash){
            return axiosClient.get(`/live/watch/${lhash}`)
                .then(({data}) => {
                    return data;
                })
        },
        getResellerUsers({ commit }, {url = null} = {}){
            url = url || '/reseller'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setUsers', data)
                    return data;
                })
        },
        getUsers({ commit }, {url = null} = {}){
            url = url || '/users'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setUsers', data)
                    return data;
                })
        },
        searchUsers({ commit }, params){
            return axiosClient.get(`/users?email=${params}`)
                .then(({data}) => {
                    commit('setUsers', data)
                    return data;
                })
        },
        updateUser({ }, payload){
            return axiosClient.put(`/user/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        blockUser({ }, payload){
            return axiosClient.put(`/user/block/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteUser({ }, id){
            return axiosClient.delete(`/user/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getUserRoles({ commit }, {url = null} = {}){
            url = url || '/roles'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setGuard', data)
                    return data;
                })
        },
        storeRole({ }, payload){
            return axiosClient.post(`/guard/role/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        updateRole({ }, payload){
            return axiosClient.put(`/guard/role/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteRole({ }, id){
            return axiosClient.delete(`/guard/role/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        getRolePermission({ }, roleId){
            return axiosClient.get(`/guard/role-permission/${roleId}`)
                .then(({data}) => {
                    return data;
                })
        },
        getUserPermissions({ commit }, {url = null} = {}){
            url = url || '/permissions'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setGuard', data)
                    return data;
                })
        },
        storePermissions({ }, payload){
            return axiosClient.post(`/guard/permission/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        updatePermission({ }, payload){
            return axiosClient.put(`/guard/permission/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deletePermission({ }, id){
            return axiosClient.delete(`/guard/permission/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        permissionsAssignRole({ }, payload){
            return axiosClient.post(`/guard/assign-permissions`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getArticles({ commit }, {url = null} = {}){
            url = url || '/articles'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setArticles', data)
                    return data;
                })
        },
        storeArticle({ }, payload){
            return axiosClient.post('/article/store', payload)
                .then(({data}) => {
                    return data;
                })
        },
        editArticle({ }, id){
            return axiosClient.get(`/article/edit/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        updateArticle({ }, payload){
            return axiosClient.put(`/article/update/${payload.id}`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        deleteArticle({ }, id){
            return axiosClient.delete(`/article/delete/${id}`)
                .then(({data}) => {
                    return data;
                })
        },
        article({ }, name){
            return axiosClient.get(`/article/${name}`)
                .then(({data}) => {
                    return data;
                })
        },
    },
    mutations: {
        setArticles: (state, data) => {
            state.articles = data;
        },
        setGuard: (state, data) => {
            state.userGuard = data;
        },
        setUsers: (state, data) => {
            state.users = data;
        },
        setliveStreams: (state, data) => {
            state.liveStream = data;
        },
        setWebsites: (state, data) => {
            state.websites = data;
        },
        setPlaylist: (state, data) => {
            state.playlist = data;
        },
        setChannels: (state, data) => {
            state.channels = data;
        },
        getExternalContent: (state, data) => {
            state.externalContent = data;
        },
        setContents: (state, data) => {
            state.contents = data;
        },
        setSuccessNotification: (state, info) => {
            state.notifySuccess = info
        },
        setErrorNotification: (state, info) => {
            state.notifyError = info
        },
        updatePersonalInfo: (state, userInfo) => {
            state.user.data = userInfo.user;
            localStorage.setItem('userInfo', JSON.stringify(userInfo.user));
        },
        logout: state => {
            state.user.data = {};
            state.user.token = null;
        },
        setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.data = userData.user;
            state.user.permissions = userData.permissions;
            localStorage.setItem('userInfo', JSON.stringify(userData.user));
            localStorage.setItem('TOKEN', userData.token);
            localStorage.setItem('can', userData.permissions);
        }
    },
    modules: {}
})

export default store;