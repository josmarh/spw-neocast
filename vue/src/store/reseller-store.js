import { createStore } from "vuex";
import axiosClient from "../axios";

const resellerStore = createStore({
    state: {},
    getters: {},
    actions: {
        register({ }, payload) {
            return axiosClient.post(`/reseller/register`, payload)
                .then(({data}) => {
                    return data;
                })
        },
    },
    mutations: {},
    modules: {}
})

export default resellerStore;