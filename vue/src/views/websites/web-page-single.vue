<template>
    <div>
        <web-page-component :config="model" class="min-h-screen">
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
                <div class="mt-4 mb-6 text-center text-lg" v-html="model.description"></div>
                <div>
                    <video-player
                        v-if="channelType.includes('Playlist (On demand)')"
                        :options="videoOptions" 
                        :playlistOptions="playlist" 
                        :shareOptions="share"
                        :showShare="videoOptionsCustom.share"
                        :showTitle="videoOptionsCustom.title"
                        @playedVideo="sendPlayEvent"
                        :logoOptions="logoOptions"
                        :playerColor="playerColor"
                        :adsTag="adsUrl"
                    />
                    <video-player-linear 
                        v-else
                        :options="videoOptionsLinear" 
                        :shareOptions="share"
                        :showShare="true"
                        :showTitle="false"
                        :logoOptions="logoOptions"
                        :playerColor="playerColor"
                        :adsTag="adsUrl"
                        :loopPlaylist="loopPlaylist"
                        @playedVideo="sendPlayEventLinear"
                    />
                </div>
                <div v-if="model.channelCount > 1" class="">
                    <h5 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white flex">Channels</h5>
                    <div 
                        class="mt-6 grid xl:grid-cols-4 md:grid-cols-2 xl:grid-gap-3 md:grid-gap-2 place-content-center">
                        <div v-for="(c) in model.channels" :key="c.id">
                            <div class="cortana w-72 bg-white rounded-lg
                                border border-gray-200 shadow-md
                                dark:bg-gray-800 dark:border-gray-700 mb-3"
                            >
                                <!-- display channels -->
                                <div v-if="c.channel_hash == $route.params.chash" class="badge-overlay w-full z-10 uppercase px-2">
                                    <span 
                                        class="bg-green-100 text-green-800 text-sm font-medium 
                                        px-2.5 py-1.5 rounded dark:bg-green-200 dark:text-green-900
                                        inline-flex mt-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="px-2 text-sm">Watching</span>
                                    </span>
                                </div>
                                <span class="flex">
                                    <a :href="`/w/${$route.params.str}/channel/${c.channel_hash}`" 
                                        class="item-center cursor-pointer">
                                        <!-- <video :src="c.poster" class="rounded-t-lg h-[12rem]"></video> -->
                                        <img 
                                            :src="c.thumbnail"
                                            class="rounded-t-lg h-[12rem]"
                                        >
                                    </a>
                                </span>
                                <div class="title-overlay">{{c.title}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  v-if="isContentSet == 3">
                <div class="flex justify-center items-center h-screen">
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
import VideoPlayer from '../../components/VideoPlayerChannel.vue';
import VideoPlayerLinear from '../../components/VideoPlayerLinearMain.vue';
import store from '../../store';
import { ref, onMounted, getCurrentInstance } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const internalInstance = getCurrentInstance();

let isContentSet = ref(0);
let model = ref({
    title: '',
    description: '',
    showHeader: '',
    pageLayout: '',
    logo: null,
    channelCount: null,
    channels: [],
    tmpChannels: [],
    footerText: '',
    menuNavigation: [],
    bgColor: '',
    fontColor: '',
    favicon: null,
    siteSeo: ''
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
const videoOptionsLinear = {
  autoplay: false,
  controls: true,
  muted: false,
  loop: false,
  sources: [
    {
      src: '',
      type: 'video/mp4',
    }
  ],
  poster: '',
  bigPlayButton: true,
  controlBar: {
    fullscreenToggle: true,
    pictureInPictureToggle: true,
    remainingTimeDisplay: true,
    volumePanel: true,
    currentTimeDisplay: true,
    timeDivider: true,
    durationDisplay: true,
    progressControl: true
  }
}
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
let logoOptions = ref({
  type: 'img',
  image: '',
  opacity: 0.9,
  position: '',
  show: false,
});
let playerColor = ref('#6366F1');
let adsUrl = ref('')
let twitterHandle = ref('');
let streamLink = ref('');
let channelType = ref('');

const _getContent = async () => {
    isContentSet.value = 1;

    await store
        .dispatch('getWebsiteContent', route.params.str)
        .then((res) => {
            if(res.data) {
                let data = res.data;
                
                model.value.title = data.title
                model.value.description = data.description;
                model.value.showHeader = data.header
                model.value.pageLayout = data.page_layout
                model.value.logo = data.logo
                model.value.channelCount = JSON.parse(data.channel).length
                model.value.footerText = data.footer_text
                model.value.bgColor = data.bg_color
                model.value.fontColor = data.font_color
                model.value.channels = JSON.parse(data.channel)
                // model.value.siteSeo =  data.seo_site_meta

                // manipulating the favicon tags, meta tags
                let setFavicon = document.getElementsByTagName('link')[0];
                let setTitle = document.getElementsByTagName('title')[0];
                let setMeta = document.getElementsByTagName('meta')[2];

                setFavicon.href = data.favicon != null ? data.favicon : 'https://favicon.ico';
                setTitle.innerHTML = data.title;
                setMeta.content = data.seo_site_meta;

                // assign player behaviour 
                videoOptions.value.autoplay = data.autoplay == 0 ? false : true
                videoOptions.value.controls = data.controls == 1 ? true : false
                videoOptions.value.muted = data.volume == 1 ? false : true
                videoOptionsCustom.value.title = data.content_title == 1 ? true : false
                videoOptionsCustom.value.share = data.share_button == 1 ? true : false

                videoOptionsLinear.autoplay = data.autoplay == 0 ? false : true
                videoOptionsLinear.muted = data.volume == 1 ? false : true
                
                getWebsiteChannels(data.whash);       
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

const getWebsiteChannels = async (whash) => {
    store
        .dispatch('getWebsiteChannels', whash)
        .then((res) => {
            if(res.data.length){
                model.value.channels = res.data;

                // assign menus
                for(let m of model.value.channels) {
                    model.value.menuNavigation.push({
                        name: m.title,
                        href: `/w/${route.params.str}/channel/${m.channel_hash}`
                    })
                }
                getChannelInfo();
                // getPlaylist(route.params.chash);
            }else {
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

const getChannelInfo = () => {
    store
        .dispatch('externalChannel', route.params.chash)
        .then((res) => {
            if(res.data) {
                getPlaylist(res.data);
            } 
        })
        .catch((err) => {
            console.log(err)
        });
}

const getPlaylist = async (chash) => {
    await store
        .dispatch('getWebsitePlaylist', chash.channel_hash)
        .then((res) => {
            if(res.data.length) {
                // add to playlist 
                for(let item of res.data){
                    playlist.value.push({
                        name: item.file_name,
                        sources: [{
                            src: `${item.file_hash}`,
                            type: 'video/mp4',
                        }],
                        poster: item.thumbnail,
                        thumbnail: [
                            {
                                srcset: item.thumbnail,
                                type: 'image/jpeg',
                                media: '(min-width: 400px;)'
                            },
                            {
                                src: item.thumbnail
                            }
                        ]
                    })
                }
                // add to share button
                twitterHandle.value = chash.twitter;
                let twitter = twitterHandle.value != null ? `via @${twitterHandle.value}` : '';
                share.value.title = `Watch "${res.data[0].channel_title}" ${twitter} on `;
                const shareUrl = router.resolve({
                    name: 'ShareChannel',
                    params: { str: chash.channel_hash}
                });
                share.value.url = `https://${window.location.host+shareUrl.href}` // external sharing
                share.value.embedCode = `<iframe src='https://${window.location.host}/embed/channel/${chash.channel_hash}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`
                
                logoOptions.value.image = chash.logo == null ? chash.logo_link : chash.logo;
                logoOptions.value.position = chash.logo_position == 'left' ? 'top-left' : null;
                logoOptions.value.show = chash.logo_enable == 1 ? true : false;
                playerColor.value = chash.color;
                adsUrl.value = chash.ad_tag_url;

                channelType.value = chash.channel_type;
                streamLink.value = `${import.meta.env.VITE_STREAM_URI}/channels/${chash.stream_name}.m3u8`
                if(chash.channel_type.includes('Linear')) {
                    videoOptionsLinear.sources[0].src = `${import.meta.env.VITE_STREAM_URI}/channels/${chash.stream_name}.m3u8`;
                    videoOptionsLinear.sources[0].type = 'application/x-mpegURL';
                    videoOptionsLinear.poster = res.data[0].thumbnail;
                    if(chash.channel_type.includes('Looped')){ videoOptionsLinear.loop = true; }else{ videoOptionsLinear.loop = false; }
                    videoOptionsLinear.controlBar.fullscreenToggle = false;
                    videoOptionsLinear.controlBar.pictureInPictureToggle = false;
                    videoOptionsLinear.controlBar.remainingTimeDisplay = false;
                    videoOptionsLinear.controlBar.progressControl = false;
                }

                isContentSet.value = 2;
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

// redundant
const _getPoster = async () => {
    let poster = [];

    for(let c of model['_rawValue'].channels) {
        await store
            .dispatch('getWebsitePlaylist', c.channel_hash)
            .then((res) => {
                for(let d of res.data) {
                    poster.push({
                        chash: d.channel_hash,
                        video: d.thumbnail
                    })
                }
            })
    }
    
    // remove duplicate 
    let filterPoster = poster.filter((v,i,a)=>a.findIndex(v2=>(v2.chash===v.chash))===i);

    // add 1st video link to channel array
    // for box thumbnail
    for (let i of filterPoster){
        for(let v of model['_rawValue'].channels) {
            if(v.channel_hash == i.chash) {
                v['poster'] = i.video
            }
        }
    }
    // console.log(model['_rawValue'].channels)
}

const sendPlayEvent = async (data) => {
  store.dispatch('sendVideoViews', {
    videoUrl: data,
    chash: route.params.chash
  })
}

const sendPlayEventLinear = () => {
  store.dispatch('sendVideoViews', {
    videoUrl: '',
    chash: route.params.chash
  })
}

onMounted(() => {
    _getContent();
})
</script>

<style scoped>
.cortana{
    position: relative;
}
.title-overlay {
  position: absolute; 
  bottom: 0; 
  background: rgb(0, 0, 0);
  background: rgba(0, 0, 0, 0.5); /* Black see-through */
  color: #f1f1f1; 
  width: 100%;
  transition: .5s ease;
  opacity:1;
  color: white;
  font-size: 15px;
  font-weight: 'bold';
  padding: 7px;
  text-align: center;
  border-bottom-left-radius: 7px;
  border-bottom-right-radius: 7px;
}

.badge-overlay {
    position: absolute; 
    top: 0;
}

</style>