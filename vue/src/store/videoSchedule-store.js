import { createStore } from "vuex";
import axiosClient from "../axios";

export default createStore({
    state: {
        video: {
            data: {}
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
        }
    },
    mutations: {
        setVideoSchedule: (state, data) => {
            state.video = data
        }
    },
    modules: {}
})