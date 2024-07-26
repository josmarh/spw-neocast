<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
          <TransitionChild as="template" 
            enter="ease-out duration-300" 
            enter-from="opacity-0" 
            enter-to="opacity-100" 
            leave="ease-in duration-200" 
            leave-from="opacity-100" 
            leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
          </TransitionChild>

          <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
              <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[50rem] w-full">
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-200 sm:mx-0 sm:h-10 sm:w-10">
                        <font-awesome-icon icon="fa-solid fa-tv"/>
                      </div>
                      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900 mt-1"> {{ channelName }} </DialogTitle>
                      </div>
                    </div>
                    <div class="sm:items-start">
                      <div class="mt-2">
                        <!-- video display -->
                        <div v-if="ChannelPlaylistCheck == 1" class="flex justify-center py-20">
                          <!-- spinner state -->
                          <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                              <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                          </svg>
                        </div>
                        <div v-if="ChannelPlaylistCheck == 2">
                          <video-player-linear
                            :options="videoOptionsLinear" 
                            :shareOptions="share"
                            :showShare="true"
                            :showTitle="false"
                            :logoOptions="logoOptions"
                            :playerColor="playerColor"
                            :adsTag="adsUrl"
                            :loopPlaylist="loopPlaylist"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex justify-between">
                    <!-- copy action  -->
                    <div class="" v-if="ChannelPlaylistCheck == 2">
                        <el-tooltip
                        class="box-item"
                        effect="dark"
                        :content="copyText"
                        placement="top">
                            <button
                            class="inline-flex items-center px-3 
                            py-2 text-sm font-medium text-center 
                            text-white bg-blue-700 
                            hover:bg-blue-800 focus:ring-0 
                            focus:outline-none focus:ring-blue-300 
                            dark:bg-blue-600 dark:hover:bg-blue-700 
                            dark:focus:ring-blue-800"
                            @click="copyStreamLink(streamLink)">
                            <font-awesome-icon icon="fa-solid fa-link" class="mr-1"/>
                            Stream link
                            </button>
                        </el-tooltip>
                    </div>
                    <button type="button" 
                      class="mt-3 w-full inline-flex justify-center border 
                      border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium 
                      text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-offset-2 
                      focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto  sm:text-sm" 
                      @click="open = false" ref="cancelButtonRef">Cancel</button>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import videoPlayerLinear from '../VideoPlayerLinearMain.vue'

const props = defineProps({
    streamLink: String,
    openPreview: Boolean,
    channelName: String
})
const emit = defineEmits(['updateOpenPreview'])
const open = ref(props.openPreview)

const videoOptionsLinear = ref({
    autoplay: false,
    controls: true,
    muted: false,
    loop: false,
    sources: [{
        src: null,
        type: 'application/x-mpegURL',
    }],
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
})
const share = ref({
    socials: ['fbFeed', 'tw'],

    url: props.streamLink,
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

let logoOptions = ref({
    type: 'img',
    image: '',
    opacity: 0.9,
    position: '',
    show: false,
});
let playerColor = ref('#6366F1');
let adsUrl = ref('')
let loopPlaylist = ref(false);
let ChannelPlaylistCheck = ref(0)

let copyText = ref('Copy')

watch(() => props.openPreview, (newVal, oldVal) => {
    if(newVal){
        ChannelPlaylistCheck.value = 1
        open.value = newVal
        videoOptionsLinear.value.sources[0].src = props.streamLink
        ChannelPlaylistCheck.value = 2
    }
})

watch(open, (newVal, oldVal) => {
    emit('updateOpenPreview', newVal)
})

function copyStreamLink(streamLink){
    navigator.clipboard.writeText(streamLink);
    copyText.value = 'Copied'
    setTimeout(() => copyText.value = 'Copy',700)
}

onMounted(() => {
    if(props.streamLink){
        videoOptionsLinear.value.sources[0].src = props.streamLink
        ChannelPlaylistCheck.value = 2
    }
})
</script>

<style>

</style>