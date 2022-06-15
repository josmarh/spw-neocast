<template>
    <div>
        <web-page-component 
            :title="model.title"
            :showHeader="model.showHeader"
            :pageLayout="model.pageLayout"
            :logo="model.logo"
            :channelCount="model.channelCount"
            :footerText="model.footerText"
        >
            <Notification/>
            <div v-if="isContentSet == 1">
                <div class="flex justify-center py-40">
                    <svg role="status"
                        class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-purple-600" 
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                </div>
            </div>
            <div v-if="isContentSet == 2">
                <div>
                    <video-player 
                        :options="videoOptions" 
                        :playlistOptions="playlist" 
                        :shareOptions="share"
                        :showShare="videoOptionsCustom.share"
                        :showTitle="videoOptionsCustom.title"
                        @playedVideo="sendPlayEvent"
                    />
                </div>
                <div v-if="model.channelCount > 1" class="mt-12">
                    <h5 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Channels</h5>
                    <div class="mt-6 grid xl:grid-cols-4 md:grid-cols-2 xl:grid-gap-3 md:grid-gap-2 place-content-center">
                        <div v-for="c in model.channels" :key="c.id">
                            <div class="w-72 bg-white rounded-lg
                                border border-gray-200 shadow-md
                                dark:bg-gray-800 dark:border-gray-700 mb-3"
                            >
                                <!-- display channels -->
                                <span class="flex">
                                    <a href="#" class="item-center cursor-pointer">
                                        <video src="" class="rounded-t-lg h-[12rem]"></video>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  v-if="isContentSet == 3">
                <div class="flex justify-center items-center mt-12">
                    <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="text-2xl text-gray-900 dark:text-white">No channel available</h5>
                        <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                            <img src="../../assets/no_content.png" class="xl:w-82 xl:h-82" />
                        </div>
                    </div>
                </div>
            </div>
        </web-page-component>
    </div>
</template>

<script setup>
import WebPageComponent from '../../components/WebPageComponent.vue';
import Notification from '../../components/Notification.vue';
import VideoPlayer from '../../components/VideoPlayer.vue';
import store from '../../store';
import { ref, onMounted, getCurrentInstance } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const internalInstance = getCurrentInstance();

let isContentSet = ref(0);
let model = ref({
    title: '',
    showHeader: '',
    pageLayout: '',
    logo: null,
    channelCount: null,
    channels: null,
    footerText: ''
});

const playlist = ref([]);
const videoOptionsCustom = ref({
  title: true,
  share: true
});
const videoOptions = ref({
  autoplay: false,
  controls: true,
  muted: false,
  loop: false
})
const share = ref({
    socials: ['fbFeed', 'tw'],

    url: '',
    title: '',
    description: '',
    image: 'https://dummyimage.com/1200x630',

    // required for Facebook and Messenger
    fbAppId: '74883939828939939900',
    // optional for Facebook
    redirectUri: window.location.href + '#close',

    // optional for VK
    isVkParse: true,

    // optinal embed code
    embedCode : ''
})

const _getContent = () => {
    isContentSet.value = 1;

    store
        .dispatch('getWebsiteContent', route.params.str)
        .then((res) => {
            if(res.data) {
                let data = res.data;
                isContentSet.value = 2;
                model.value.title = data.title
                model.value.showHeader = data.header
                model.value.pageLayout = data.page_layout
                model.value.logo = data.logo
                model.value.channelCount = JSON.parse(data.channel).length
                model.value.footerText = data.footer_text
                model.value.channels = JSON.parse(data.channel)
            }else{
                isContentSet.value = 3;
            }
        })
        .catch((err) => {
            isContentSet.value = 3;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

const getPlaylist = (chash) => {

}

onMounted(() => {
    _getContent();
})
</script>

<style>

</style>