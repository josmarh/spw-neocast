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
    },
    mutations: {
        setVideoSchedule: (state, data) => {
            state.video = data
        },
        setAiActors: (state, data) => {
            state.aiActors = data
        }
    },
    modules: {}
})