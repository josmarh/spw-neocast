import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import VueProgressBar from "@aacassandra/vue3-progressbar";
import VuePlyr from 'vue-plyr';
import Vue3ColorPicker from "vue3-colorpicker";
import './index.css';
import 'flowbite';
import 'vue-plyr/dist/vue-plyr.css';
import "vue3-colorpicker/style.css";
// import "./assets/custom-tailwind.css"

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faRobot, faArrowUpFromBracket } from '@fortawesome/free-solid-svg-icons'
library.add( faRobot, faArrowUpFromBracket )

const options = {
    color: "#0E9F6E",
    failedColor: "red",
    thickness: "3px",
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
    .component('font-awesome-icon', FontAwesomeIcon)
    .use(VuePlyr, {
        plyr: {}
    })
    .use(VueProgressBar, options)
    .use(router)
    .use(store)
    .use(Vue3ColorPicker)
    .mount('#app')
