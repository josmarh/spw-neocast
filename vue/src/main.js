import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import VueProgressBar from "@aacassandra/vue3-progressbar";
import VuePlyr from 'vue-plyr';
import './index.css';
import 'flowbite';
import 'vue-plyr/dist/vue-plyr.css';
// import vuetify from './plugins/vuetify'
// import { loadFonts } from './plugins/webfontloader'

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
// loadFonts()

createApp(App)
  .use(VuePlyr, {
    plyr: {}
  })
  .use(VueProgressBar, options)
  .use(router)
  .use(store)
  // .use(vuetify)
  .mount('#app')
