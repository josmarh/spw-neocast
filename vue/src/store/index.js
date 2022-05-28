import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: JSON.parse(localStorage.getItem('userInfo')),
            token: localStorage.getItem('TOKEN')
        },
        contents: {
            data: [],
            links: [],
            meta: {}
        },
        externalContent: {}
    },
    getters: {},
    actions: {
        register({ commit }, user){
            return axiosClient.post('/register', user)
                .then(({data}) => {
                    commit('setUser', data)
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
        },
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
                    commit('updateContent', data)
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
        deleteContent({ commit }, id){
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
    },
    mutations: {
        getExternalContent: (state, data) => {
            state.externalContent = data;
        },
        updateContent: (state, data) => {
            // state.contents = state.contents.data.map(item => data.contents.id === item.id || item);
        },
        setContents: (state, data) => {
            state.contents = data;
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
            localStorage.setItem('userInfo', JSON.stringify(userData.user));
            localStorage.setItem('TOKEN', userData.token);
        }
    },
    modules: {}
})

export default store;