<template>
  <div>
    <page-component title="Channels">
      <notification />
      <div v-if="!channels.data.length">
        <div class="flex justify-center items-center">
          <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-2xl text-gray-900 dark:text-white">Hi! Your channels list looks empty. Create your first channel now.</h5>
            <div class="flex justify-center items-center mt-6">
              <router-link
                :to="{ name: 'CreateChannel' }"
                class="
                  group
                  relative
                  flex
                  justify-center
                  py-3
                  px-4
                  border border-transparent
                  text-sm
                  font-medium
                  text-white
                  bg-indigo-600
                  hover:bg-indigo-700
                  focus:outline-none
                "
              >
                Create channel
              </router-link>
            </div>
            <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
              <img src="../../assets/no_channel.png" class="xl:w-82 xl:h-82" />
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <div class="p-4">
            <!-- filters  -->
            <div class="relative z-0">
              <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none"
              >
                <svg
                  class="w-5 h-5 text-gray-500 dark:text-gray-400"
                  fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                  ></path>
                </svg>
              </div>
              <input
                type="text"
                id="name-search"
                v-model="nameFilter"
                class="
                  block
                  pl-10
                  py-2
                  px-0
                  xl:w-1/4
                  sm:w-1/3
                  text-sm text-gray-900
                  bg-transparent
                  border-0 border-b-2 border-gray-300
                  appearance-none
                  dark:text-white
                  dark:border-gray-600
                  dark:focus:border-blue-500
                  focus:outline-none focus:ring-0 focus:border-blue-600
                  peer
                "
                placeholder=" "
              />
              <label
                for="name-search"
                class="
                  absolute
                  pl-10
                  text-sm text-gray-500
                  dark:text-gray-400
                  duration-300
                  transform
                  -translate-y-6
                  scale-75
                  top-3
                  -z-10
                  origin-[0]
                  peer-focus:left-0
                  peer-focus:text-blue-600
                  peer-focus:dark:text-blue-500
                  peer-placeholder-shown:scale-100
                  peer-placeholder-shown:translate-y-0
                  peer-focus:scale-75 peer-focus:-translate-y-6
                "
                >Search by channel name
              </label>
            </div>
          </div>
          <!-- table data  -->
          <div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th scope="col" class="p-4"></th>
                  <th scope="col" class="px-6 py-3">
                    Channel Name
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Views
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Videos
                  </th>
                  <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="c in channels.data" :key="c.id"
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="w-4 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" 
                      fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                  </td>
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{c.title}}
                  </th>
                  <td class="px-6 py-4">
                    0
                  </td>
                  <td class="px-6 py-4">
                    0
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex">
                      <div class="">
                        <button type="button" 
                          class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                          focus:outline-none focus:ring-gray-100 
                          font-medium text-xs sm:text-xs px-5 py-2.5 text-center 
                          inline-flex items-center dark:focus:ring-gray-500 mr-2 mb-2">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                          Add Video
                        </button>
                      </div>
                      <div class="">
                        <button type="button" 
                          class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                          focus:outline-none focus:ring-gray-100 
                          font-medium text-xs sm:text-xs px-5 py-2.5 text-center 
                          inline-flex items-center dark:focus:ring-gray-500 mr-2 mb-2">
                          <svg xmlns="http://www.w3.org/2000/svg" 
                            class="h-4 w-4 mr-3 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                          </svg>
                          Preview & Embed
                        </button>
                      </div>
                      <div class="">
                        <button type="button" 
                          class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                          focus:outline-none focus:ring-gray-100 
                          font-medium text-sm px-5 py-2.5 text-center 
                          inline-flex items-center dark:focus:ring-gray-500 mr-2">
                          <svg xmlns="http://www.w3.org/2000/svg" 
                            class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                          </svg>
                        </button>
                      </div>
                      <div class="">
                        <button type="button"
                          class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                          focus:outline-none focus:ring-gray-100 
                          font-medium text-sm px-5 py-2.5 text-center 
                          inline-flex items-center dark:focus:ring-gray-500 mr-2">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                          </svg>
                        </button>
                      </div>
                      <div class="">
                        <button type="button" @click="confirmDelete(c)"
                          class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                          focus:outline-none focus:ring-gray-100 
                          font-medium text-sm px-5 py-2.5 text-center 
                          inline-flex items-center dark:focus:ring-gray-500 mr-2">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                          fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- pagination -->
            <div class="flex justify-center mt-5">
              <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm "
                aria-label="Pagination"
              >
                <a 
                  v-for="(link, i) of channels.meta.links" 
                  :key="i"
                  :disabled="!link.url"
                  href="#"
                  @click="getForPage($event,link)"
                  aria-current="page"
                  class="relative inline-flex items-center px-4 py-2 border text-sm
                  font-medium whitespace-nowrap"
                  :class="[
                    link.active 
                    ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' 
                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                    i === 0 ? 'rounded-l-md' : '',
                    i === channels.meta.links.length - 1 ? 'rounded-r-md' : '',
                  ]"
                  v-html="link.label"
                >
                </a>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <!-- delete content modal -->
      <TransitionRoot as="template" :show="openDelete">
        <Dialog as="div" class="relative z-10" @close="openDelete = false">
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
              <TransitionChild as="template" 
                enter="ease-out duration-300" 
                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                enter-to="opacity-100 translate-y-0 sm:scale-100" 
                leave="ease-in duration-200" 
                leave-from="opacity-100 translate-y-0 sm:scale-100" 
                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                      </div>
                      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> 
                          Delete {{channelModel.title}} 
                        </DialogTitle>
                        <div class="mt-2">
                          <p class="text-sm text-gray-500">Are you sure you want to delete this content? This action cannot be undone.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                        class="w-full inline-flex justify-center border border-transparent 
                        shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white 
                        hover:bg-red-700 focus:outline-none focus:ring-offset-2 
                        focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" 
                        @click="deleteChannel(channelModel.id)"
                    >Delete</button>
                    <button type="button" 
                        class="mt-3 w-full inline-flex justify-center border border-gray-300 
                        shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 
                        hover:bg-gray-50 focus:outline-none focus:ring-offset-2 
                        focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" 
                        @click="openDelete = false" ref="cancelButtonRef"
                    >Cancel</button>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
      {{channels}}
    </page-component>
  </div>
</template>

<script setup>
import PageComponent from '../../components/PageComponent.vue'
import Notification from '../../components/Notification.vue';
import store from '../../store'
import { ref, computed, onMounted, watch, getCurrentInstance } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationIcon } from '@heroicons/vue/outline'

const internalInstance = getCurrentInstance();
const channels = computed(() => store.state.channels);
const nameFilter = ref('')
const openDelete = ref(false)
const channelModel = ref({
  id: null,
  title: null,
})

watch(nameFilter, (after, before) => {
  setTimeout(function(){
    filterChannel(after)
  }, 3000)
})

const getChannelList = async () => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch('getChannelList')
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
      internalInstance.appContext.config.globalProperties.$Progress.finish();
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();

      if (err.response.data) {
        if (err.response.data.hasOwnProperty("message")) {
          store.dispatch("setErrorNotification", err.response.data.message);
        } else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    });
}

const filterChannel = async (name) => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch('filterChannel', name)
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
      internalInstance.appContext.config.globalProperties.$Progress.finish();
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();

      if (err.response.data) {
        if (err.response.data.hasOwnProperty("message")) {
          store.dispatch("setErrorNotification", err.response.data.message);
        } else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    });
}

const deleteChannel = async (id) => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch('deleteChannel', id)
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
      store.dispatch('setSuccessNotification', res.message);
      store.dispatch('getChannelList');
      internalInstance.appContext.config.globalProperties.$Progress.finish();
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();

      if (err.response.data) {
        if (err.response.data.hasOwnProperty("message")) {
          store.dispatch("setErrorNotification", err.response.data.message);
        } else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    });
}

const confirmDelete = (c) => {
  openDelete.value = true;
  channelModel.value.id = c.id
  channelModel.value.title = c.title
}

const getForPage = (ev,link) => {
  ev.preventDefault();
  if(!link.url || link.active) {
    return;
  }
  store.dispatch("getChannelList", {url: link.url})
}

onMounted(() => {
  getChannelList();
});

</script>