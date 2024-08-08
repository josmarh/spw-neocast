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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                      </div>
                      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Embed Channel </DialogTitle>
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
                          <video-player 
                            v-if="channelType.includes('Playlist (On demand)')"
                            :options="videoOptions" 
                            :playlistOptions="playlist" 
                            :shareOptions="share"
                            :showShare="true"
                            :showTitle="true"
                            :logoOptions="logoOptions"
                            :playerColor="playerColor"
                            :adsTag="adsUrl"
                            :loopPlaylist="loopPlaylist"
                            @playedVideo="sendPlayEvent"
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
                        <!-- embed settings -->
                        <div class="grid xl:grid-cols-3 gap-3 mt-4">
                          <div>
                            <h3 class="font-bold text-md text-gray-900">Size</h3>
                            <div class="flex mt-3">
                              <div class="flex items-center mr-4">
                                <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                <input
                                  type="radio"
                                  v-model="embedFilters.isPicked"
                                  value="responsive" 
                                  name="inline-radio-group" 
                                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 
                                  dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                >
                                Responsive</label>
                              </div>
                              <div class="flex items-center mr-4">
                                <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                <input 
                                  type="radio" 
                                  v-model="embedFilters.isPicked"
                                  value="fixed" 
                                  name="inline-radio-group"
                                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300
                                  dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                >
                                Fixed</label>
                              </div>
                            </div>
                            <div v-if="embedFilters.isPicked == 'responsive'" class="mt-5">
                              <select
                                v-model="embedFilters.ratio"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 
                                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                                dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              >
                                <option value="56.25%">16:9</option>
                                <option value="75%">4:3</option>
                                <option value="100%">1:1</option>
                              </select>
                              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                                Aspect Ratio
                              </label>
                            </div>
                            <div v-else class="mt-5">
                              <div class="grid grid-cols-3 gap-1">
                                <div>
                                  <div class="">
                                    <input type="text" id="width" v-model="embedFilters.pixelWid"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm 
                                      rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full 
                                      p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                      dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                  </div>
                                </div>
                                <div class="py-2 px-7">x</div>
                                <div>
                                  <div class="">
                                    <input type="text" id="length" v-model="embedFilters.pixelLen"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm 
                                      rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full 
                                      p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                      dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                  </div>
                                </div>
                              </div>
                              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Pixels</label>
                            </div>
                          </div>
                          <div>
                            <h3 class="font-bold text-md text-gray-900">Playback options</h3>
                            <div class="mt-3">
                              <div class="flex items-center mb-4">
                                <input 
                                  v-model="embedFilters.isAutoPlay" 
                                  id="autoplay" 
                                  type="checkbox"
                                  class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 
                                  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                  focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label 
                                  for="autoplay" 
                                  class="ml-2 text-sm font-medium text-gray-900 
                                  dark:text-gray-300">Autoplay (if possible)</label>
                              </div>
                            </div>
                            <div class="mt-3">
                              <div class="flex items-center mb-4">
                                <input 
                                  v-model="embedFilters.isVolume"
                                  id="volume"
                                  type="checkbox"
                                  class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 
                                  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                  focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label 
                                  for="volume" 
                                  class="ml-2 text-sm font-medium text-gray-900 
                                  dark:text-gray-300">Volume</label>
                              </div>
                            </div>
                          </div>
                          <div>
                            <h3 class="font-bold text-md text-gray-900">Display options</h3>
                            <div class="mt-3">
                              <div class="flex items-center mb-4">
                                <input 
                                  v-model="embedFilters.sControls"
                                  id="controls"
                                  type="checkbox"
                                  class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 
                                  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                  focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label 
                                  for="controls" 
                                  class="ml-2 text-sm font-medium text-gray-900 
                                  dark:text-gray-300">Show controls</label>
                              </div>
                            </div>
                            <div class="mt-3">
                              <div class="flex items-center mb-4">
                                <input 
                                  v-model="embedFilters.sContentTitle"
                                  id="content-title"
                                  type="checkbox"
                                  class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 
                                  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                  focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label 
                                  for="content-title" 
                                  class="ml-2 text-sm font-medium text-gray-900 
                                  dark:text-gray-300">Show content title</label>
                              </div>
                            </div>
                            <div class="mt-3">
                              <div class="flex items-center mb-4">
                                <input 
                                  v-model="embedFilters.sShare"
                                  id="share-button"
                                  type="checkbox"
                                  class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 
                                  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                  focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label
                                  for="share-button"
                                  class="ml-2 text-sm font-medium text-gray-900 
                                  dark:text-gray-300">Show share buttons</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- embed code field -->
                        <div class="mt-10">
                          <label 
                            for="code" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400"
                          >
                          Code
                          </label>
                          <textarea 
                            id="code" 
                            rows="4" 
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg 
                            border border-gray-300 focus:ring-blue-500 focus:border-blue-500 
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Emebeded Code"
                            v-model="code"
                          ></textarea>
                        </div>
                        <!-- copy action  -->
                        <div class="mt-5">
                          <button type="button" 
                            class="group relative flex justify-center py-2 px-4 border 
                            border-transparent text-sm font-medium text-white w-full
                            bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            sm:w-auto sm:text-sm"
                            @click="copyData(code, 'code')"
                          >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>&nbsp;
                            Copy embed code
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                      class="mt-3 w-full inline-flex justify-center border 
                      border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium 
                      text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-offset-2 
                      focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto  sm:text-sm" 
                      @click="openEmbed = false" ref="cancelButtonRef">Cancel</button>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';

const props = defineProps({
    show: Boolean,
    ChannelPlaylistCheck: Number
})
const emit = defineEmits(['updateShow'])
const open = ref(props.show)

watch(()=> props.show,(newVal, oldVal)=> {
    if(newVal)
    open.value = newVal
})

watch(open,(newVal,oldVal)=>{
    emit('updateShow')
})
</script>

<style>

</style>