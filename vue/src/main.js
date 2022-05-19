import { createApp } from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';
import VueProgressBar from "@aacassandra/vue3-progressbar";
import './index.css';
import 'flowbite';

const options = {
    color: "#0E9F6E",
    failedColor: "red",
    thickness: "5px",
    transition: {
      speed: "0.2s",
      opacity: "0.6s",
      termination: 300,
    },
    autoRevert: true,
    location: "top",
    inverse: false,
};

createApp(App)
    .use(VueProgressBar, options)
    .use(store)
    .use(router)
    .mount('#app')
