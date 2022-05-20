<template>
  <div>
    <page-component title="Contents">
      <div class="flex justify-center items-center w-full mb-3">
        <div class="grid xl:grid-cols-5 xl:gap-2">
          <div class="mb-3">
            <router-link :to="{name: 'Uploads'}"  
              class="group relative flex justify-center py-3 px-4 border 
              border-transparent text-sm font-medium text-white 
              bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
              </svg>
              &nbsp;
              Upload Video
            </router-link>
          </div>
          <div class="py-3 px-16">or</div>
          <div class="col-span-2">
            <div class="relative z-0">
              <input type="url" id="video-url" 
                class="block py-3 px-0 w-full text-sm text-gray-900 
                bg-transparent border-0 border-b-2 border-gray-300 
                appearance-none dark:text-white dark:border-gray-600 
                dark:focus:border-blue-500 focus:outline-none focus:ring-0 
                focus:border-blue-600 peer" placeholder=" " />
              <label for="video-url" 
                class="absolute text-sm text-gray-500 dark:text-gray-400 
                duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                peer-focus:-translate-y-6">Video URL (.m3u8 link)
              </label>
            </div>
          </div>
          <div>
            <button type="button" 
              class="group  flex justify-center py-3 px-4 border 
              border-transparent text-sm font-medium text-white 
              bg-indigo-600 hover:bg-indigo-700 focus:outline-none" 
              :disabled="isDisabled">
              Add Video URL
            </button>
          </div>
        </div>
      </div>
      <div class="flex justify-center items-center w-full">
        <div class="grid xl:grid-cols-4 xl:gap-2 p-6 bg-white border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 mt-0">
          <div class="mb-3">
            <div class="relative z-0">
              <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" 
                  stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </div>
              <input type="url" id="name-search" 
                class="block pl-10  py-2 px-0 w-full text-sm text-gray-900 
                bg-transparent border-0 border-b-2 border-gray-300 
                appearance-none dark:text-white dark:border-gray-600 
                dark:focus:border-blue-500 focus:outline-none focus:ring-0 
                focus:border-blue-600 peer" placeholder=" " />
              <label for="name-search" 
                class="absolute pl-10 text-sm text-gray-500 dark:text-gray-400 
                duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                peer-focus:-translate-y-6">Search by name
              </label>
            </div>
          </div>
          <div>
            <div class="relative z-0">
              <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" 
                  viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
              </div>
              <input type="url" id="tag-search" 
                class="block pl-10  py-2 px-0 w-full text-sm text-gray-900 
                bg-transparent border-0 border-b-2 border-gray-300 
                appearance-none dark:text-white dark:border-gray-600 
                dark:focus:border-blue-500 focus:outline-none focus:ring-0 
                focus:border-blue-600 peer" placeholder=" " />
              <label for="tag-search" 
                class="absolute pl-10 text-sm text-gray-500 dark:text-gray-400 
                duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                peer-focus:-translate-y-6">Search by tag
              </label>
            </div>
          </div>
          <div>
            <label for="select_tag" class="sr-only">Select Tags</label>
            <select id="select_tag" 
              class="block py-2 px-0 w-full text-sm text-gray-500 bg-transparent 
              border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-400 
              dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
              <option disabled selected hidden>Match any tag</option>
              <option value="any_tag">Match any tag</option>
              <option value="all_tags">Match all tags</option>
            </select>
          </div>
          <div>
            <label for="select_media_types" class="sr-only">All Media types</label>
            <select id="select_media_types" 
              class="block py-2 px-0 w-full text-sm text-gray-500 bg-transparent 
              border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-400 
              dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
              <option disabled selected hidden>All Media types</option>
              <option value="hosted_videos">Hosted Videos</option>
              <option value="external_links">External Links</option>
            </select>
          </div>
        </div>
      </div>
      <!-- main content display -->
      <div class="mt-12">
        
        <div class="grid xl:grid-cols-4 xl:grid-gap-3 place-content-center">
          <div v-for="cont in contents.contents" :key="cont.id">
          <div class="w-64 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 mb-3">
            <a href="#">
              <img class="rounded-t-lg" :src="`http://localhost:8000/${cont.file_hash}`" alt="">
            </a>
            <div class="p-5">
              <!-- <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
              </a> -->
              <p class="mb-3 font-normal text-sm text-gray-700 dark:text-gray-400">
                {{cont.file_name}}
              </p>
            </div>
          </div>  
          </div>        
        </div>
        {{contents.contents}}
      </div>
    </page-component>
  </div>
</template>

<script setup>
import PageComponent from '../../components/PageComponent.vue';
import store from '../../store';
import { ref, onMounted, getCurrentInstance, computed } from 'vue'

const internalInstance = getCurrentInstance();
const contents = computed(() => store.state.contents)

let errorMsg = ref('');

const getContents = () => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  store
    .dispatch('getContents')
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.finish();
    })
    .catch(err => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();

      if(err.response.data) {
        if (err.response.data.hasOwnProperty('message')){
          errorMsg.value = err.response.data.message
        }else {
          errorMsg.value = err.response.data.error
        }
      }
    })
}

onMounted(() => {
  getContents()
})
</script>

<style>

</style>