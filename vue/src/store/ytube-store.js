import { createStore } from "vuex";
import axiosClient from "../axios";

const ytubeStore = createStore({
    state: {
        videos: {
            kind: "",
            etag: "",
            nextPageToken: "",
            regionCode: "",
            pageInfo: {},
            items: []
        },
        iptvCategories: {
            data: []
        },
        iptvChannels: {
            data: [],
            meta: {},
            links: {}
        },
    },
    getters: {},
    actions: {
        getTrendingVideos({ commit }) {
            return axiosClient.get(`/video/ytube/trending`)
                .then(({data}) => {
                    commit('setVideos', data)
                    return data;
                })
        },
        searchVideo({ commit }, payload) {
            return axiosClient.get(`/video/ytube/search/${payload.video}`, {
                params: {
                    type: payload.type
                }
            })
                .then(({data}) => {
                    commit('setVideos', data)
                    return data;
                })
        },
        saveVideo({ }, payload) {
            return axiosClient.post(`/video/ytube/add`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getIptvCategories({ commit }) {
            return axiosClient.get(`/video/iptv/categories`)
                .then(({data}) => {
                    commit('setIptvCategories', data)
                    return data;
                })
        },
        getIptvChannels({ commit }, {url = null} = {}) {
            url = url || '/video/iptv/channels'
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setIptvChannels', data)
                    return data;
                })
        },
        filterIptvChannelCategory({ commit }, filter) {
            return axiosClient.get(`/video/iptv/channels?category=${filter.category}`)
                .then(({data}) => {
                    commit('setIptvChannels', data)
                    return data;
                })
        },
    },
    mutations: {
        setVideos: (state, data) => {
            state.videos = data;
        },
        setIptvCategories: (state, data) => {
            state.iptvCategories = data;
        },
        setIptvChannels: (state, data) => {
            state.iptvChannels = data;
        },
    },
    modules: {}
});

export default ytubeStore;