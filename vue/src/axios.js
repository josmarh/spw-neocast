import axios from 'axios';
import store from './store';
import { getCurrentInstance } from 'vue';

const internalInstance = getCurrentInstance();
const axiosClient = axios.create({
    baseURL: 'http://127.0.0.1:8000/api'
})

axiosClient.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`
    internalInstance.appContext.config.globalProperties.$Progress.start();
    return config;
})


export default axiosClient;