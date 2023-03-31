<template>
    <div>
        <div v-if="streamStatus == 2" class="lg:text-left px-10">
            <p class="mt-4 xl:text-2xl leading-8 font-bold tracking-tight text-gray-900 sm:text-3xl">
                {{model.title}}                
            </p>
        </div>
        <div v-if="streamStatus == 4" class="flex justify-center items-center mt-12">
            <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-2xl text-gray-900 dark:text-white">Stream not found</h5>
            <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                <img src="../../assets/no_content.png" class="xl:w-82 xl:h-82" />
            </div>
            </div>
        </div>
        <div v-if="streamStatus == 3" class="flex justify-center items-center mt-8 px-10 ">
            <div class="p-20 w-full bg-black border shadow-md sm:p-64 dark:bg-gray-800 dark:border-gray-700 text-center">
                <span class="text-red-700 font-medium font-bold text-4xl">OFFLINE</span>
            </div>
        </div>
        <div v-if="streamStatus == 1" class="flex justify-center py-20">
            <!-- spinner state -->
            <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
        </div>
        <div class="">
            <div v-if="streamStatus == 2" class="pl-10 pr-10 pb-20">
                <video-player
                    :options="videoOptions" 
                    :playlistOptions="playlist" 
                    :shareOptions="share"
                    :showShare="true"
                    :showTitle="true"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import Notification from '../../components/Notification.vue';
import store from '../../store';
import VideoPlayer from '../../components/VideoPlayer3.vue';
import { ref, computed, watch, onMounted, onUnmounted, getCurrentInstance } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const isChannelSet = ref(0);
const openChannelList = ref(false);
const openEmbedCode = ref(false);

let model = ref({
    id: null,
    channel: [],
    title: '',
    bsignal: false,
    record_stream: null,
    streamKey: '',
    liveStatus: '',
    latestStreams: []
});
let embedFilters = ref({
    isPicked: 'responsive',
    ratio: '56.25%',
    pixelWid: '640',
    pixelLen: '360',
    isAutoPlay: false,
    isVolume: true,
    sControls: true,
});
let embedVideoShow = ref(0)
let embedLink = ref('')
let shareLink = ref('')
const code = ref('')
const videoOptions = ref({
    autoplay: false,
    controls: true,
    muted: false,
    loop: false,
    sources: [
        {
            src: '',
            type: 'application/x-mpegURL',
        }
    ]
});
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
});
const embedUrl = router.resolve({
    name: 'LiveEmbed',
    params: { lhash: route.params.lhash}
});
const shareUrl = router.resolve({
    name: 'LiveShare',
    params: { lhash: route.params.lhash}
});
const streamStatus = ref(0)

const getLiveStreamContent = async () => {
    streamStatus.value = 1;
    await store
        .dispatch('liveStreamWatch', route.params.lhash)
        .then((res) => {
            if(res.data) {
                let data = res.data;

                model.value.id = data.id
                model.value.streamKey = data.stream_key
                model.value.title = data.title
                model.value.channel = JSON.parse(data.channels)
                model.value.bsignal = data.broadcast_signal == 0 ? false : true,
                model.value.liveStatus = data.live_status
                model.value.latestStreams = res.latestStreams

                share.value.url = `https://${window.location.host+shareUrl.href}`;
                share.value.embedCode = `<iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`;
                share.value.title = `Watch "${model.value.title}" Live on `;

                videoOptions.value.sources[0].src = `${import.meta.env.VITE_STREAM_URI}/hls/${data.stream_key}/index.m3u8`;
                checkStreamUri();
            } else {
                streamStatus.value = 4;
            }
        })
        .catch((err) => {
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

let timeoutStream;
let saveLiveVideo = ref(0) // 0: default, 1: ready to save, 2: save is ongoing, 3: saved
const checkStreamUri = () => {
    let lopper = () => {
        timeoutStream = setTimeout( async () => {
            await fetch(`${import.meta.env.VITE_STREAM_URI}/hls/${model['_rawValue'].streamKey}/index.m3u8`)
            .then(res => res)
            .then(data => {
                if(data.status) {
                    if(data.status == 404) {
                        streamStatus.value = 3;
                        model.value.liveStatus = 'idle'
                        lopper();
                    } else if(data.status == 200) {
                        streamStatus.value = 2;
                        model.value.liveStatus = 'live'
                        // check live status if is not there then download video after 10 sec
                        
                        if(saveLiveVideo.value == 1) {
                            // run save
                            setTimeout(() => {
                                // storeLiveVideo();
                            }, 10000);
                        }

                        lopper();
                    } else if(data.status == 500) {
                        streamStatus.value = 3;
                        model.value.liveStatus = 'idle'
                        lopper();
                    }
                }
                // console.log(`from fetch ${data.status}`)
            })
            .catch(err => {
                streamStatus.value = 3;
                lopper();
                console.log(`error ${err}`)
            })

        }, 10000)
    }
    lopper();
}

onMounted(() => {
    getLiveStreamContent();
})

onUnmounted(() => {
    clearTimeout(timeoutStream);
})
</script>

<style>

</style>