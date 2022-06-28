<template>
    <div>
        <div v-if="ChannelPlaylistCheck == 3" class="flex justify-center items-center mt-12">
            <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-2xl text-gray-900 dark:text-white">No content found</h5>
            <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                <img src="../../assets/no_content.png" class="xl:w-82 xl:h-82" />
            </div>
            </div>
        </div>
        <!-- video display -->
        <div v-if="ChannelPlaylistCheck == 1" class="flex justify-center py-20">
            <!-- spinner state -->
            <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
        </div>
        <div v-if="ChannelPlaylistCheck == 2">
          <video-player 
            :options="videoOptions" 
            :playlistOptions="playlist" 
            :shareOptions="share"
            :showShare="videoOptionsCustom.share"
            :showTitle="videoOptionsCustom.title"
            @playedVideo="sendPlayEvent"
          />
        </div>
    </div>
</template>

<script setup>
import store from "../../store";
import VideoPlayer from '../../components/VideoPlayer.vue';
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const ChannelPlaylistCheck = ref(0)

let contentCheck = ref(false)
let data = ref({
    filename: null,
    fileurl: null,
    shareurl: null
})

const videoOptions = ref({
  autoplay: false,
  controls: true,
  muted: false,
  loop: false,
  // playbackRates: [0.5, 1, 1.5, 2],
  // sources: [
  //   {
  //     src: 'https://muxed.s3.amazonaws.com/ink.mp4',
  //     type: 'video/mp4',
  //   }
  // ]
})

const videoOptionsCustom = ref({
  title: true,
  share: true
})

const playlist = ref([]);

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

// Get param contents 
const getExternalContent = async () => {
    await store
    .dispatch('getChannelEmbedPlayerList', route.params.str)
    .then((res) => {
        const shareUrl = router.resolve({
            name: 'ShareVideo',
            params: { str: route.params.str}
        });

        data.value.filename = res.content.file_name
        data.value.fileurl = res.content.file_hash
        data.value.shareurl = `https://${window.location.host+shareUrl.href}` // external sharing

        if (data.value.fileurl == null){
            contentCheck.value = true
        }
    });
    
};

const getPlaylist = async () => {
    playlist.value = [];
    ChannelPlaylistCheck.value = 1;

    await store
    .dispatch('getChannelEmbedPlayerList', route.params.str)
    .then((res) => {
      // pass playlist content
      if(res.data.length) {
        for(let item of res.data){
          playlist.value.push({
            name: item.file_name,
            sources: [{
              src: item.file_hash,
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
        ChannelPlaylistCheck.value = 2;
        share.value.title = `Watch "${res.data[0].channel_title}" on `;
        const shareUrl = router.resolve({
          name: 'ShareChannel',
          params: { str: route.params.str }
        });
        share.value.url = `https://${window.location.host+shareUrl.href}` // external sharing
        share.value.embedCode = `<iframe src='https://${window.location.host}/embed/channel/${route.params.str}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`
      }else {
        ChannelPlaylistCheck.value = 3;
      }
      
    })
}

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

const sendPlayEvent = async (data) => {
  store.dispatch('sendVideoViews', {
    videoUrl: data,
    chash: route.params.str
  })
}

onMounted(() => {
  getPlaylist();
  contentSettings();
});
</script>

<style>

</style>