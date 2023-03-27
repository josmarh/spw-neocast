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
    },
    mutations: {
        setVideos: (state, data) => {
            state.videos = data;
        },
    },
    modules: {}
});

export default ytubeStore;