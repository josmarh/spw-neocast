<template>
    <div>
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
import VideoPlayer from '../../components/VideoPlayer.vue';
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();

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
  playbackRates: [0.5, 1, 1.5, 2],
  sources: [
    {
      src: 'https://muxed.s3.amazonaws.com/ink.mp4',
      type: 'video/mp4',
    }
  ],
})

const playlist = [
    {
        name: 'Sintel',
        sources: [{
        src: 'http://media.w3.org/2010/05/sintel/trailer.mp4',
        type: 'video/mp4',
        }],
        poster: 'http://media.w3.org/2010/05/sintel/poster.png',
        thumbnail: [
        {
            srcset: 'http://media.w3.org/2010/05/sintel/poster.png',
            type: 'image/jpeg',
            media: '(min-width: 400px;)'
        },
        {
            src: 'http://media.w3.org/2010/05/sintel/poster.png'
        }
        ],
        duration: 90,
    }
];

const share = {
    socials: ['fb', 'tw'],

    url: window.location.href,
    title: 'videojs-share',
    description: 'video.js share plugin',
    image: 'https://dummyimage.com/1200x630',

    // required for Facebook and Messenger
    fbAppId: '74883939828939939900',
    // optional for Facebook
    redirectUri: window.location.href + '#close',

    // optional for VK
    isVkParse: true,

    // optinal embed code
    embedCode : '<iframe src="' + window.location.href + '" width="560" height="315" frameborder="0" allowfullscreen></iframe>'
}

// Get param contents 
const getExternalContent = async () => {
    await store
    .dispatch('getChannelPlayerList', route.params.str)
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

onMounted(() => {

});
</script>

<style>

</style>