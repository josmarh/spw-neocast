import { createStore } from "vuex";
import axiosClient from "../axios";

export default createStore({
    state: {
        video: {
            data: {}
        },
        aiActors: {
            items: [],
            nextPage: 0,
            prevPage: 0,
            currentPage: 0,
            total: 0
        },
        aiVideoLanguages: [],
        aiVideoScript: {
            data: {}
        },
        timezones: [],
        channels: [],
        videos: [],
        videoSchedules: {
            data: [],
            meta: {},
            links: {}
        }
    },
    getters: {},
    actions: {
        getVideoSchedule({ commit }, videoId) {
            return axiosClient.get(`/video/${videoId}/schedule`)
                .then(({data}) => {
                    commit('setVideoSchedule', data)
                    return data;
                })
        },
        saveVideoSchedule({}, payload) {
            return axiosClient.post(`/video/schedule`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        generateAiScript({}, payload){
            return axiosClient.post(`/video/ai/content`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getAiVideoLanguages({ commit }){
            return axiosClient.get(`/video/ai/languages`)
                .then(({data}) => {
                    commit('setAiVideoLanguages', data)
                    return data;
                })
        },
        lastVideoScript({ commit }){
            return axiosClient.get(`/video/ai/script`)
                .then(({data}) => {
                    commit('setAiVideoScript', data)
                    return data;
                })
        },
        getAiActors({ commit }, query){
            return axiosClient.get(`/video/ai/actors`, {
                params: {
                    pageNumber: query.pageNumber,
                    pageSize: query.pageSize
                }
            })
                .then(({data}) => {
                    commit('setAiActors', data)
                    return data;
                })
        },
        generateAiVideo({ }, payload){
            return axiosClient.post(`/video/ai/generate-video`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        checkAiVideoStatus({ }, videoId){
            return axiosClient.get(`/video/ai/video-status/${videoId}`)
                .then(({data}) => {
                    return data;
                })
        },
        checkVideoSaveStatus({ }, videoId){
            return axiosClient.get(`/video/ai/save-status/${videoId}`)
                .then(({data}) => {
                    return data;
                })
        },
        getTimezones({ commit }){
            return axiosClient.get(`/timezones`)
                .then(({data}) => {
                    commit('setTimezones', data)
                    return data;
                })
        },
        getChannelSelect({ commit }){
            return axiosClient.get(`/channel/select`)
                .then(({data}) => {
                    commit('setChannels', data)
                    return data;
                })
        },
        getVideoSelect({ commit }){
            return axiosClient.get(`/video/select`)
                .then(({data}) => {
                    commit('setVideos', data)
                    return data;
                })
        },
        storeSchedule({}, payload){
            return axiosClient.post(`/schedule/store`, payload)
                .then(({data}) => {
                    return data;
                })
        },
        getVideoSchedules({ commit }){
            return axiosClient.get(`/video/schedules`)
                .then(({data}) => {
                    commit('setVideoSchedules', data)
                    return data;
                })
        },
        paginateVideoSchedule({ commit }, url){
            return axiosClient.get(url)
                .then(({data}) => {
                    commit('setVideoSchedules', data)
                    return data;
                })
        }
    },
    mutations: {
        setVideoSchedule: (state, data) => {
            state.video = data
        },
        setAiActors: (state, data) => {
            state.aiActors = data
        },
        setAiVideoLanguages: (state, data) => {
            state.aiVideoLanguages = data
        },
        setAiVideoScript: (state, data) => {
            state.aiVideoScript = data
        },
        setTimezones: (state, data) => {
            state.timezones = data
        },
        setChannels: (state, data) => {
            state.channels = data
        },
        setVideos: (state, data) => {
            state.videos = data
        },
        setVideoSchedules: (state, data) => {
            state.videoSchedules = data
        }
    },
    modules: {}
})