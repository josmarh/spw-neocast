import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: JSON.parse(sessionStorage.getItem('userInfo')),
            token: sessionStorage.getItem('TOKEN')
        }
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
                    sessionStorage.clear();
                    return response;
                })
        },
        updatePersonalInfo({ commit }, user){
            let userId = this.state.user.data.id;

            return axiosClient.put(`/personal-info/${userId}`, user)
            .then(({data}) => {
                commit('updatePersonalInfo', data)
                return data;
            })
        },
        updatePassword({ commit }, userPass){
            let userId = this.state.user.data.id;

            return axiosClient.put(`/password/update/${userId}`, userPass)
                .then(({data}) => {
                    commit('updatePassword')
                    return data;
                })
        }
    },
    mutations: {
        updatePersonalInfo: (state, userInfo) => {
            state.user.data = userInfo.user;
            sessionStorage.setItem('userInfo', JSON.stringify(userInfo.user));
        },
        logout: state => {
            state.user.data = {};
            state.user.token = null;
        },
        setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.data = userData.user;
            sessionStorage.setItem('userInfo', JSON.stringify(userData.user));
            sessionStorage.setItem('TOKEN', userData.token);
        }
    },
    modules: {}
})

export default store;