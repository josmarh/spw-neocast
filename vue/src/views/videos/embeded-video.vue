<template>
    <div>
        <!-- <div v-if="playConfig.title == 1" class="lg:text-center">
            <p class="mt-2 mb-3 xl:text-3xl leading-8 font-bold tracking-tight text-gray-900 sm:text-2xl">
                {{data.filename}}
            </p>
        </div> -->
        <div v-if="data.fileurl !== null" class="h-screen">
            <!-- audio element -->
            <!-- <vue-plyr v-if="data.filename.includes('.mp3')">
                <audio controls playsinline >
                <source
                    :src="data.fileurl"
                    type="audio/mp3"
                    class="pt-20"
                />
                </audio>
            </vue-plyr> -->
            <!-- video element -->
            <!-- <vue-plyr v-else :options="{
                'autoplay': playConfig.autoplay, 
                'muted': playConfig.muted, 
                'controls': playConfig.controls,
            }">
                <video
                    controls
                    playsinline
                    data-poster=""
                    id="embed-video"
                >
                    <source
                        size="720"
                        :src="data.fileurl"
                        type="video/mp4"
                    />
                    <source
                        size="1080"
                        :src="data.fileurl"
                        type="video/mp4"
                    />
                </video>
            </vue-plyr> -->
            <video-player 
                :options="videoOptions"
                :shareOptions="share"
                :showShare="videoOptionsCustom.share"
                :showTitle="videoOptionsCustom.title"
            />
        </div>
        <!-- <div v-if="playConfig.share == 1" class="mt-3 mb-4 ml-5">
            <button 
                @click="socialShare(data.externalurl, data.filename, 'facebook')"
                type="button" 
                class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 
                focus:outline-none focus:ring-[#3b5998]/50 font-medium 
                text-sm px-5 py-2.5 text-center inline-flex items-center 
                dark:focus:ring-[#3b5998]/55 mr-2 mb-2">
                <svg class="w-4 h-4 mr-2 -ml-1" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M279.1 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.4 0 225.4 0c-73.22 0-121.1 44.38-121.1 124.7v70.62H22.89V288h81.39v224h100.2V288z"></path></svg>
                Share on Facebook
            </button>
            <button 
                @click="socialShare(data.externalurl, data.filename, 'twitter')"
                type="button" 
                class="text-white bg-[#1da1f2] hover:bg-[#1da1f2]/90 focus:ring-4 
                focus:outline-none focus:ring-[#1da1f2]/50 font-medium 
                text-sm px-5 py-2.5 text-center inline-flex items-center 
                dark:focus:ring-[#1da1f2]/55 mr-2 mb-2">
                <svg class="w-4 h-4 mr-2 -ml-1" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.4 151.7c.325 4.548 .325 9.097 .325 13.65 0 138.7-105.6 298.6-298.6 298.6-59.45 0-114.7-17.22-161.1-47.11 8.447 .974 16.57 1.299 25.34 1.299 49.06 0 94.21-16.57 130.3-44.83-46.13-.975-84.79-31.19-98.11-72.77 6.498 .974 12.99 1.624 19.82 1.624 9.421 0 18.84-1.3 27.61-3.573-48.08-9.747-84.14-51.98-84.14-102.1v-1.299c13.97 7.797 30.21 12.67 47.43 13.32-28.26-18.84-46.78-51.01-46.78-87.39 0-19.49 5.197-37.36 14.29-52.95 51.65 63.67 129.3 105.3 216.4 109.8-1.624-7.797-2.599-15.92-2.599-24.04 0-57.83 46.78-104.9 104.9-104.9 30.21 0 57.5 12.67 76.67 33.14 23.72-4.548 46.46-13.32 66.6-25.34-7.798 24.37-24.37 44.83-46.13 57.83 21.12-2.273 41.58-8.122 60.43-16.24-14.29 20.79-32.16 39.31-52.63 54.25z"></path></svg>
                Share on Twitter
            </button>
        </div> -->
        <div v-if="contentCheck == true" class="flex justify-center items-center mt-12">
            <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-2xl text-gray-900 dark:text-white">No content found</h5>
            <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                <img src="../../assets/no_content.png" class="xl:w-82 xl:h-82" />
            </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import store from "../../store";
import VideoPlayer from '../../components/VideoPlayer2.vue';
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();

let contentCheck = ref(false)
let data = ref({
    filename: null,
    fileurl: null,
    externalurl: null
})
const playConfig = ref({
    autoplay: false,
    muted: false,
    controls: ['play-large','play','progress','settings','duration','mute','volume','fullscreen','captions','restart'],
    title: 0,
    share: 0,
})

const videoOptions = ref({
  autoplay: false,
  controls: true,
  muted: false,
  loop: false,
  sources: [
    {
      src: '',
      type: 'video/mp4',
    }
  ]
})
const videoOptionsCustom = ref({
  title: true,
  share: true
})
const share = ref({
    socials: ['fbFeed', 'tw'],

    url: '',
    title: '',
    description: '',
    image: 'https://dummyimage.com/1200x630',

    // required for Facebook and Messenger
    fbAppId: import.meta.env.VITE_FB_APP_ID,
    // optional for Facebook
    redirectUri: window.location.href + '#close',

    // optional for VK
    isVkParse: true,

    // optinal embed code
    embedCode : ''
})


// Get param contents 
const getExternalContent = async () => {
    await store
    .dispatch("getExternalContent", route.params.str)
    .then((res) => {
        const shareUrl = router.resolve({
            name: 'ShareVideo',
            params: { str: route.params.str}
        });
        const embedUrl = router.resolve({
            name: 'EmbedVideo',
            params: { str: route.params.str}
        });

        data.value.filename = res.content.file_name
        data.value.fileurl = res.content.file_hash
        data.value.externalurl = `https://${window.location.host+shareUrl.href}` // external sharing

        //videojs player
        videoOptions.value.sources[0].src = res.content.file_hash;
        share.value.url = `https://${window.location.host+shareUrl.href}`;
        share.value.embedCode = `<iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`;
        share.value.title = `Watch "${res.content.file_name}" on `;

        if (data.value.fileurl == null){
            contentCheck.value = true
        }
    })
    .catch((err) => {
        contentCheck.value = true
        if (err.response.data) {
            if (err.response.data.hasOwnProperty("message")) {
            errorMsg.value = err.response.data.message;
            } else {
            errorMsg.value = err.response.data.error;
            }
        }
    });
    
};

const contentSettings = () => {
    
    if(route.query.autoplay == 1)
        videoOptions.value.autoplay = true

    if(route.query.volume == 0)
        videoOptions.value.muted = true
    
    if(route.query.controls == 0)
        videoOptions.value.controls = false

    if(route.query.title == 1){
        videoOptionsCustom.value.title = true
    } else {
        videoOptionsCustom.value.title = false
    }

    if(route.query.share == 1){
        videoOptionsCustom.value.share = true
    } else {
        videoOptionsCustom.value.share = false
    }
}

const socialShare = (shareLink, contentName, platform) => {
    let url, encodeUrl, start;

    if(platform === 'twitter') {
        start = contentName.includes('.mp3') ? 'Listen to' : 'Watch';
        url = `https://twitter.com/intent/tweet?url=${shareLink}&text=${start} "${contentName}" `;
        encodeUrl = encodeURI(url);
        window.open(encodeUrl, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
    }else {

    }
}

onMounted(() => {
    getExternalContent();
    contentSettings();
});
</script>

<style>

</style>