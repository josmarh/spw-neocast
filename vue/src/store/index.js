import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: {
                // name: 'Tom Cook',
                // email: 'tom@example.com',
                // imageUrl:
                //     'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
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
        }
    },
    mutations: {
        logout: state => {
            state.user.data = {};
            state.user.token = null;
        },
        setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.data = userData.user;
            sessionStorage.setItem('TOKEN', userData.token)
        }
    },
    modules: {}
})

export default store;