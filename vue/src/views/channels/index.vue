<template>
  <div>
    <page-component title="Channels">
      <notification />
      
      <div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <div class="p-4">
            <!-- create button -->
            <div class="inline-flex rounded-md shadow-sm mb-3" role="group">
              <router-link
                :to="{ name: 'CreateChannel' }"
                class="group relative flex justify-center
                py-2 px-3 border border-transparent
                text-sm font-medium text-white
                bg-indigo-600 hover:bg-indigo-700
                focus:outline-none"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create Channel
              </router-link>
              <Menu as="div" class="relative">
                <div>
                  <MenuButton 
                    class="max-w-xs bg-gray-300 flex items-center 
                    text-sm focus:outline-none focus:ring-offset-2 
                    focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">Open user menu</span>
                    <a
                      class="group relative flex justify-center
                      py-2.5 px-3 border border-transparent
                      text-sm font-medium text-white
                      bg-indigo-600 hover:bg-indigo-700
                      focus:outline-none cursor-pointer"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                      </svg>
                    </a>
                  </MenuButton>
                </div>
                <transition 
                  enter-active-class="transition ease-out duration-100" 
                  enter-from-class="transform opacity-0 scale-95" 
                  nter-to-class="transform opacity-100 scale-100" 
                  leave-active-class="transition ease-in duration-75" 
                  leave-from-class="transform opacity-100 scale-100" 
                  leave-to-class="transform opacity-0 scale-95">
                  <MenuItems class="origin-top-right absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <MenuItem v-for="item in channelNavigation" :key="item.name" v-slot="{ active }">
                      <router-link 
                        :to="item.to" 
                        :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                        {{ item.name }}
                      </router-link>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
            <!-- filters  -->
            <div class="relative z-0 xl:float-right">
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
                class="block pl-10 py-2 px-0 xl:w-full sm:w-full
                  text-sm text-gray-900 bg-transparent
                  border-0 border-b-2 border-gray-300
                  appearance-none dark:text-white
                  dark:border-gray-600 dark:focus:border-blue-500
                  focus:outline-none focus:ring-0 focus:border-blue-600
                  peer"
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
          <div v-if="channelListCheck == 1" class="flex justify-center py-20">
            <!-- spinner state -->
            <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
          </div>
          <div v-if="channelListCheck == 3">
            <div class="flex justify-center items-center">
              <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h5 class="text-2xl text-gray-900 dark:text-white">No channel available</h5>
                <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                  <img src="../../assets/no_channel.png" class="xl:w-82 xl:h-82" />
                </div>
              </div>
            </div>
          </div>
          <!-- table data  -->
          <div v-if="channelListCheck == 2">
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
                    {{c.total_views != null ? c.total_views : 0}}
                  </td>
                  <td class="px-6 py-4">
                    {{c.total_vidoes}}
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex">
                      <div class="">
                        <button type="button" @click="addVideo(c.channel_hash, c.title)"
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
                        <button type="button" @click="embedChannel(c.channel_hash, c.title)"
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
                        <button type="button" @click="duplicateModal(c.channel_hash, c.title)"
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
                        <button type="button" @click="editChannel(c.channel_hash)"
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
            <div class="flex justify-center mt-5 mb-5">
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
      <!-- delete channel modal -->
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
                <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                      </div>
                      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> 
                          Delete - {{channelModel.title}} 
                        </DialogTitle>
                        <div class="mt-2">
                          <p class="text-sm text-gray-500">Are you sure you want to delete this channel? This action cannot be undone.</p>
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
      <!-- embed channel modal -->
      <TransitionRoot as="template" :show="openEmbed">
        <Dialog as="div" class="relative z-10" @close="openEmbed = false">
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
                <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[50rem] sm:w-full">
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
                            :options="videoOptions" 
                            :playlistOptions="playlist" 
                            :shareOptions="share"
                            :showShare="true"
                            :showTitle="true"
                            @playedVideo="sendPlayEvent"
                          />
                        </div>
                        <!-- embed settings -->
                        <div class="grid grid-cols-3 gap-3 mt-4">
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
                                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
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
                            border-transparent text-sm font-medium text-white 
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
      <!-- add videos to Playlist -->
      <TransitionRoot as="template" :show="openAddVideo">
        <Dialog as="div" class="relative z-10" @close="openAddVideo = false">
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
                <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[50rem] sm:w-full">
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                      </div>
                      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Add video - {{channelModel.title}} </DialogTitle>
                      </div>
                    </div>
                    <!-- display video list content  -->
                    <div>
                      <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                          <li class="mr-2" role="presentation">
                            <button @click="tabSwitch('allVideos')"
                              class="inline-block p-4 rounded-t-lg border-b-2 " 
                              :class="[
                                allVideos==true 
                                ? 'border-blue-600 border-b-2 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 dark:border-blue-500'
                                : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700'
                              ]"
                              id="profile-tab" 
                              data-tabs-target="#profile" 
                              type="button" role="tab" 
                              aria-controls="profile" 
                              aria-selected="true">All Videos
                            </button>
                          </li>
                          <li class="mr-2" role="presentation">
                            <button @click="tabSwitch('selectedVideos')"
                              class="inline-block p-4 rounded-t-lg border-b-2" 
                              :class="[
                                selectedVideos==true 
                                ? 'border-blue-600 border-b-2 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 dark:border-blue-500'
                                : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700'
                              ]"
                              id="dashboard-tab" data-tabs-target="#dashboard" 
                              type="button" role="tab" aria-controls="dashboard" 
                              aria-selected="false">Added Videos
                            </button>
                          </li>
                        </ul>
                      </div>
                      <div id="myTabContent">
                        <div v-if="allVideos==true"
                          class="p-4 bg-white-50 rounded-lg dark:bg-gray-800"
                          :class="[allVideos==false ? 'hidden' : '']"
                          id="profile" role="tabpanel" aria-labelledby="profile-tab">
                          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <div v-if="playlistChecks.allVideos == 1" class="flex justify-center py-20">
                              <!-- spinner state -->
                              <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                              </svg>
                            </div>
                            <div v-if="playlistChecks.allVideos = 2">
                              <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                  <tr>
                                    <th scope="col" class="p-4">
                                      <div class="flex items-center">
                                        <input id="checkbox-all" type="checkbox" 
                                          class="w-4 h-4 text-blue-600 bg-gray-100 
                                          border-gray-300 rounded focus:ring-blue-500
                                          dark:focus:ring-blue-600 dark:ring-offset-gray-800
                                          focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                      </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3"></th>
                                    <th scope="col" class="px-6 py-3"></th>
                                    <th scope="col" class="px-6 py-3"></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="v in videoContent.data" :key="v.id"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-4 p-4">
                                      <div class="flex items-center">
                                        <input type="checkbox" :value="v.id" v-model="videoToAddChecks.videoToAdd"
                                          class="check-all-videos w-4 h-4 text-blue-600 bg-gray-100
                                          border-gray-300 rounded focus:ring-blue-500
                                          dark:focus:ring-blue-600 dark:ring-offset-gray-800
                                          focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-1" class="sr-only">checkbox</label>
                                      </div>
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                      <div class="w-10 h-10">
                                        <video
                                        :src="v.file_hash"
                                        class="rounded-t-lg">
                                        </video>
                                      </div>
                                    </th>
                                    <td class="px-6 py-4" :title="v.file_name">
                                      {{v.file_name.replace(/(.{40})..+/, "$1…")}}
                                    </td>
                                    <td class="px-6 py-4">
                                      {{v.media_length}}
                                    </td>
                                  </tr>
                                  {{videoToAdd}}
                                </tbody>
                              </table>
                              <div class="flex justify-center mt-5" v-if="videoContent.data.length">
                                <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm "
                                  aria-label="Pagination"
                                >
                                <a 
                                  v-for="(link, i) of videoContent.meta.links"
                                  :key="i"
                                  :disabled="!link.url"
                                  href="#"
                                  @click="getForPageVideo($event,link)"
                                  aria-current="page"
                                  class="relative inline-flex items-center px-4 py-2 border text-sm
                                  font-medium whitespace-nowrap"
                                  :class="[
                                    link.active 
                                    ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' 
                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                    i === 0 ? 'rounded-l-md' : '',
                                    i === videoContent.meta.links.length - 1 ? 'rounded-r-md' : '',
                                  ]"
                                  v-html="link.label"
                                >
                                </a>
                                </nav>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- channel playlist videos -->
                        <div v-else class="p-4 bg-gray-50 rounded-lg dark:bg-gray-800"
                          :class="[selectedVideos==false ? 'hidden' : '']"
                          id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                          <div v-if="playlistChecks.selectedVideos == 1" class="flex justify-center py-20">
                            <!-- spinner state -->
                            <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                              <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                          </div>
                          <div v-if="playlistChecks.selectedVideos == 2">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                              <tbody>
                                <tr v-for="v in ChannelPlaylist.data" :key="v.id"
                                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    <div class="w-10 h-10">
                                      <video
                                      :src="v.file_hash"
                                      class="rounded-t-lg">
                                      </video>
                                    </div>
                                  </th>
                                  <td class="" :title="v.file_name">
                                    {{v.file_name.replace(/(.{40})..+/, "$1…")}}
                                  </td>
                                  <td class="px-6 py-4">
                                    {{v.media_length}}
                                  </td>
                                  <td>
                                    <div class="flex">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                      </svg>
                                      {{v.views}}
                                    </div>
                                  </td>
                                  <td>
                                    <div class="flex">
                                      <!-- video embed button  -->
                                      <!-- <button type="button" @click="embedPlistVideo()"
                                        class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                        focus:outline-none focus:ring-gray-100 
                                        font-medium text-sm px-5 py-2.5 text-center 
                                        inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                          class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                        </svg>
                                      </button> -->
                                      <!-- delete from channel playlist -->
                                      <button type="button" @click="deletePlistVideo(v.cpid)"
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
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <div class="flex justify-center mt-5" v-if="ChannelPlaylist.data.length">
                                <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm "
                                  aria-label="Pagination"
                                >
                                <a 
                                  v-for="(link, i) of ChannelPlaylist.meta.links"
                                  :key="i"
                                  :disabled="!link.url"
                                  href="#"
                                  @click="getForPagePlaylist($event,link)"
                                  aria-current="page"
                                  class="relative inline-flex items-center px-4 py-2 border text-sm
                                  font-medium whitespace-nowrap"
                                  :class="[
                                    link.active 
                                    ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' 
                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                    i === 0 ? 'rounded-l-md' : '',
                                    i === ChannelPlaylist.meta.links.length - 1 ? 'rounded-r-md' : '',
                                  ]"
                                  v-html="link.label"
                                >
                                </a>
                                </nav>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                      class="mt-3 w-full inline-flex justify-center border 
                      border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium 
                      text-gray-700 hover:bg-gray-50 focus:outline-none 
                      focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" 
                      @click="openAddVideo = false" 
                      ref="cancelButtonRef">Cancel
                    </button>
                    <button type="button" 
                      class="text-white bg-blue-700 hover:bg-blue-800 
                      focus:outline-none focus:ring-blue-300 
                      font-medium text-sm w-full sm:w-auto px-5 py-2.5 
                      text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                      dark:focus:ring-blue-800" :disabled="isDisabled"
                      @click="addVideoAction"
                    >Accept</button>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
      <!-- duplicate channel modal -->
      <TransitionRoot as="template" :show="openDup">
        <Dialog as="div" class="relative z-10" @close="openDup = false">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
          </TransitionChild>

          <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
              <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" 
                          fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                      </div>
                      <div class=" text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <DialogTitle as="h3" class="text-lg mt-2 leading-6 font-medium text-gray-900"> Duplicate Channel </DialogTitle>
                      </div>
                    </div>
                    <div class="mt-8">
                      <!--  -->
                      <div class="relative z-0">
                        <input type="text" id="floating_standard" 
                          class="block py-2.5 px-0 w-full text-sm 
                          text-gray-900 bg-transparent border-0 
                          border-b-2 border-gray-300 appearance-none 
                          dark:text-white dark:border-gray-600 
                          dark:focus:border-blue-500 focus:outline-none 
                          focus:ring-0 focus:border-blue-600 peer" 
                          placeholder=" " 
                          v-model="channelModel.title"
                        />
                        <label for="floating_standard" 
                          class="absolute text-sm text-gray-500 
                          dark:text-gray-400 duration-300 
                          transform -translate-y-6 scale-75 
                          top-3 -z-10 origin-[0] peer-focus:left-0 
                          peer-focus:text-blue-600 peer-focus:dark:text-blue-500 
                          peer-placeholder-shown:scale-100 
                          peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                          peer-focus:-translate-y-6">Channel name
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                      class="mt-3 w-full inline-flex justify-center border border-gray-300 
                      shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 
                      hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" 
                      @click="openDup = false" ref="cancelButtonRef">Cancel
                    </button>
                    <button type="button" 
                      class="text-white bg-blue-700 hover:bg-blue-800 
                      focus:outline-none focus:ring-blue-300 
                      font-medium text-sm w-full sm:w-auto px-5 py-2.5 
                      text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                      dark:focus:ring-blue-800" :disabled="isDisabled"
                      @click="duplicateChannel">Accept
                    </button>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
      
    </page-component>
  </div>
</template>

<script setup>
import PageComponent from '../../components/PageComponent.vue';
import Notification from '../../components/Notification.vue';
import store from '../../store';
import VideoPlayer from '../../components/VideoPlayer.vue';
import { ref, computed, onMounted, watch, getCurrentInstance } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { ExclamationIcon } from '@heroicons/vue/outline';
import { useRouter, useRoute } from 'vue-router';
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { MenuIcon } from '@heroicons/vue/outline'

const router = useRouter();
const route = useRoute();
const internalInstance = getCurrentInstance();
const channels = computed(() => store.state.channels);
const videoContent = computed(() => store.state.contents);
const ChannelPlaylist = computed(() => store.state.playlist)
const ChannelPlaylistCheck = ref(0)
const channelListCheck = ref(0)
const nameFilter = ref('')
const openDelete = ref(false)
const openEmbed = ref(false)
const openAddVideo = ref(false)
const openDup = ref(false)
const allVideos = ref(true)
const selectedVideos = ref(false)
const isDisabled = ref(false)
const channelModel = ref({
  id: null,
  title: null,
})
const videoToAddChecks = ref({
  channelId: null,
  videoToAdd: []
})

const embedFilters = ref({
  isPicked: 'responsive',
  ratio: '56.25%',
  pixelWid: '640',
  pixelLen: '360',
  isAutoPlay: false,
  isVolume: true,
  sControls: true,
  sContentTitle: true,
  sShare: true
});

const playlist = ref([]);
const share = ref({
    socials: ['fbFeed', 'tw'],

    url: window.location.href,
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
let playlistChecks = ref({
  allVideos: null,
  selectedVideos: null
})

const code = ref('')
const embedSrc = ref('')
const channelNavigation = [
  { name: 'Scheduled (linear)', to: {name: 'Scheduled'} },
  { name: 'Looped (linear)', to: {name: 'Looped'} },
  { name: 'Playlist (on demand)', to: {name: 'Ondemand'} },
];

watch(nameFilter, (after, before) => {
  setTimeout(function(){
    filterChannel(after)
  }, 3000)
})

watch(embedFilters, (after, before) => {
  embedCode(after)
}, {deep: true})

const getChannelList = async () => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  channelListCheck.value = 1;

  await store
    .dispatch('getChannelList')
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      if(res.data.length)
        channelListCheck.value = 2
      else
        channelListCheck.value = 3
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      channelListCheck.value = 3
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

const editChannel = (hash) => {
  router.push({
    name: 'EditChannel',
    params: { hash: hash}
  })
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
      openDelete.value = false
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      openDelete.value = false

      if (err.response.data) {
        if (err.response.data.hasOwnProperty("message")) {
          store.dispatch("setErrorNotification", err.response.data.message);
        } else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    });
}

const duplicateChannel = async () => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  isDisabled.value = true;
  store
    .dispatch('duplicateChannel',{
      title: channelModel['_rawValue'].title,
      chash: videoToAddChecks['_rawValue'].channelId
    })
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
      store.dispatch('setSuccessNotification', res.message);
      store.dispatch('getChannelList');
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      openDup.value = false
      isDisabled.value = false;
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      openDup.value = false
      isDisabled.value = false;

      if(err.response){
        if (err.response.data) {
          if (err.response.data.hasOwnProperty("message")) {
            store.dispatch("setErrorNotification", err.response.data.message);
          } else {
            store.dispatch("setErrorNotification", err.response.data.error);
          }
        }
      }
    });
}

const duplicateModal = (chash, title) => {
  channelModel.value.title = `Copy of ${title}`;
  videoToAddChecks.value.channelId = chash;
  openDup.value = true;
}

// get video list to add to channel
const addVideo = async (chash, title) => {
  openAddVideo.value = true;
  playlistChecks.value.allVideos = 1;
  await store.dispatch('getVideos', {chash: chash});
  playlistChecks.value.allVideos = 2;
  videoToAddChecks.value.channelId = chash
  channelModel.value.title = title
}

// submit selected video to add to channel playlist
const addVideoAction = async () => {
  // validate checks
  if(!videoToAddChecks.value.videoToAdd.length){
    return false;
  }

  let channelHash = videoToAddChecks.value.channelId;
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch('addToPlaylist', {
      channelId: videoToAddChecks['_rawValue'].channelId,
      videos: videoToAddChecks['_rawValue'].videoToAdd
    })
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
      store.dispatch('setSuccessNotification', res.message);
      store.dispatch('getVideos', {chash: channelHash});
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      openAddVideo.value = false
      videoToAddChecks.value.videoToAdd = []
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      openAddVideo.value = false
      if(err.response) {
        if (err.response.data) {
          if (err.response.data.hasOwnProperty("message")) {
            store.dispatch("setErrorNotification", err.response.data.message);
          } else {
            store.dispatch("setErrorNotification", err.response.data.error);
          }
        }
      }
    });
}

// get added list videos
const getSelectedVideos = async () => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  let channelId = videoToAddChecks['_rawValue'].channelId;
  playlistChecks.value.selectedVideos = 1;

  await store
    .dispatch('getPlaylist', channelId)
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      // pass playlist content
      playlistChecks.value.selectedVideos = 2;
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      openAddVideo.value = false
      playlistChecks.value.selectedVideos = 2;
      
      if(err.response) {
        if (err.response.data) {
          if (err.response.data.hasOwnProperty("message")) {
            store.dispatch("setErrorNotification", err.response.data.message);
          } else {
            store.dispatch("setErrorNotification", err.response.data.error);
          }
        }
      }
    });
}

// delete video from channel playlist
const deletePlistVideo = async (playlistVideoId) => {
  let channelId = videoToAddChecks['_rawValue'].channelId;
  internalInstance.appContext.config.globalProperties.$Progress.start();

  store
    .dispatch('deletePlistVideo', playlistVideoId)
    .then((res) => {
      store.dispatch('setSuccessNotification', res.message);
      store.dispatch('getPlaylist', channelId);
      internalInstance.appContext.config.globalProperties.$Progress.finish();
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      openAddVideo.value = false
      if(err.response) {
        if (err.response.data) {
          if (err.response.data.hasOwnProperty("message")) {
            store.dispatch("setErrorNotification", err.response.data.message);
          } else {
            store.dispatch("setErrorNotification", err.response.data.error);
          }
        }
      }
    });

}

const copyData = (data, elmId) => {
  document.getElementById(elmId).select()
  navigator.clipboard.writeText(data);
  alert("Copied to clipboard!");
}

const embedChannel = async (hash, title) => {
  const embedUrl = router.resolve({
    name: 'EmbedChannel',
    params: { str: hash}
  });

  embedSrc.value = `https://${window.location.host+embedUrl.href}`
  code.value = `<div style='position: relative; padding-bottom: ${embedFilters.value.ratio}; height: 0;'><iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&controls=1&title=1&share=1' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%;' frameborder='0' allow='autoplay' allowfullscreen></iframe></div>`;
  
  openEmbed.value = true;
  playlist.value = [];
  ChannelPlaylistCheck.value = 1;
  videoToAddChecks.value.channelId = hash;

  await store
    .dispatch('getPlaylist', hash)
    .then((res) => {
      // pass playlist content
      if(res.data.length) {
        for(let item of res.data){
          playlist.value.push({
            name: item.file_name,
            sources: [{
              src: `${item.file_hash}#t=0.1`,
              type: 'video/mp4',
            }],
            // poster: 'http://media.w3.org/2010/05/sintel/poster.png',
            thumbnail: [
              {
                srcset: 'http://media.w3.org/2010/05/sintel/poster.png',
                type: 'image/jpeg',
                media: '(min-width: 400px;)'
              },
              {
                src: 'http://media.w3.org/2010/05/sintel/poster.png'
              }
            ]
          })
        }
        share.value.embedCode = code.value
        share.value.title = `Watch "${title}" on `;
        const shareUrl = router.resolve({
          name: 'ShareChannel',
          params: { str: hash}
        });
        share.value.url = `https://${window.location.host+shareUrl.href}` // external sharing
      }
      ChannelPlaylistCheck.value = 2;
    })
}

const sendPlayEvent = async (data) => {
  let chash = videoToAddChecks.value.channelId;

  store.dispatch('sendVideoViews', {
    videoUrl: data,
    chash: chash
  })
}

const embedCode = (item) => {
  if(item.isPicked == 'responsive') {
    code.value = `<div style='position: relative; padding-bottom: ${item.ratio}; height: 0;'><iframe src='${embedSrc.value}?autoplay=${item.isAutoPlay == true ? 1 : 0}&volume=${item.isVolume == true ? 1 : 0}&controls=${item.sControls == true ? 1 : 0}&title=${item.sContentTitle == true ? 1 : 0}&share=${item.sShare == true ? 1 : 0}' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%;' frameborder='0' allow='autoplay' allowfullscreen></iframe></div>`
    share.value.embedCode = code.value
  }else {
    code.value = `<iframe src='${embedSrc.value}?autoplay=${item.isAutoPlay == true ? 1 : 0}&volume=${item.isVolume == true ? 1 : 0}&controls=${item.sControls == true ? 1 : 0}&title=${item.sContentTitle == true ? 1 : 0}&share=${item.sShare == true ? 1 : 0}' width='${item.pixelWid}' height='${item.pixelLen}' frameborder='0' allow='autoplay' allowfullscreen></iframe>`
    share.value.embedCode = code.value
  }
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

const getForPageVideo = async (ev,link) => {
  ev.preventDefault();
  if(!link.url || link.active) {
    return;
  }
  await store.dispatch('getVideosPage', {url: link.url})
}

const getForPagePlaylist = async (ev,link) => {
  ev.preventDefault();
  if(!link.url || link.active) {
    return;
  }
  await store.dispatch('getPlaylistPage', {url: link.url})
}

const tabSwitch = (type) => {
  if(type=='allVideos'){
    allVideos.value=true;
    selectedVideos.value=false;
    let channelId = videoToAddChecks['_rawValue'].channelId;
    playlistChecks.value.allVideos = 1;
    store.dispatch('getVideos', {chash: channelId});
    playlistChecks.value.allVideos = 2;
    isDisabled.value = false
  }else{
    allVideos.value=false;
    selectedVideos.value=true;
    isDisabled.value = true
    getSelectedVideos();
  }
}

const videoOptions = {
  autoplay: false,
  controls: true,
  muted: false,
  loop: false,
  // playbackRates: [0.5, 1, 1.5, 2],
  // sources: [
  //   {
  //     src: '',
  //     type: 'video/mp4',
  //   }
  // ],
}



onMounted(() => {
  getChannelList();
});

</script>