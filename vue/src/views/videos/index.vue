<template>
  <div>
    <page-component title="Contents" 
      :class="[videoListCheck == 0 || videoListCheck == 1 || contents.data.length < 2 ? 'h-screen bg-gray-100': '']">
      <notification />
      <!-- upload or import via link section -->
      <div class="flex justify-center items-center w-full mb-3">
        <div class="grid xl:grid-cols-5 xl:gap-2">
          <div class="mb-3">
            <router-link
              :to="{ name: 'Uploads' }"
              class="group relative flex justify-center
                py-3 px-4 border border-transparent
                text-sm font-medium text-white
                bg-indigo-600 hover:bg-indigo-700
                focus:outline-none">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                />
              </svg>
              &nbsp; Upload Video
            </router-link>
          </div>
          <div class="py-3 px-16">or</div>
          <div class="col-span-2">
            <div class="relative z-0">
              <input
                v-model="externalLink"
                type="url"
                id="video-url"
                class="block py-3 px-0 w-full text-sm 
                text-gray-900 bg-transparent border-0 
                border-b-2 border-gray-300 appearance-none
                dark:text-white dark:border-gray-600
                dark:focus:border-blue-500 focus:outline-none 
                focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
              />
              <label
                for="video-url"
                class="
                  absolute
                  text-sm text-gray-500
                  dark:text-gray-400
                  duration-300 transform
                  -translate-y-6 scale-75
                  top-3 -z-10 origin-[0]
                  peer-focus:left-0
                  peer-focus:text-blue-600
                  peer-focus:dark:text-blue-500
                  peer-placeholder-shown:scale-100
                  peer-placeholder-shown:translate-y-0
                  peer-focus:scale-75 peer-focus:-translate-y-6
                "
                >Video URL (.m3u8 link)
              </label>
            </div>
          </div>
          <div>
            <button
              @click="addExternalContent"
              type="button"
              class="
                group
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
              :disabled="isDisabled"
            >
              Add Video URL
            </button>
          </div>
        </div>
      </div>
      <!-- filter contents section -->
      <div class="flex justify-center items-center w-full">
        <div
          class="
            grid
            xl:grid-cols-4 xl:gap-2
            p-6
            bg-white
            border border-gray-200
            shadow-md
            dark:bg-gray-800 dark:border-gray-700
            mt-0
          "
        >
          <div class="mb-3">
            <div class="relative z-0">
              <div
                class="
                  flex
                  absolute
                  inset-y-0
                  left-0
                  items-center
                  pl-3
                  pointer-events-none
                "
              >
                <svg
                  class="w-5 h-5 text-gray-500 dark:text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                  ></path>
                </svg>
              </div>
              <input
                type="url"
                id="name-search"
                class="
                  block
                  pl-10
                  py-2
                  px-0
                  w-full
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
                v-model="searchParam.name"
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
                >Search by name
              </label>
            </div>
          </div>
          <div>
            <div class="relative z-0">
              <div key="" class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg"
                  class="w-5 h-5 text-gray-500 dark:text-gray-400"
                  fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                >
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                  />
                </svg>
              </div>
              <input
                type="url"
                id="tag-search"
                class="
                  block
                  pl-10
                  py-2
                  px-0
                  w-full
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
                v-model="searchParam.tag"
              />
              <label
                for="tag-search"
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
                >Search by tag
              </label>
            </div>
          </div>
          <div>
            <label for="select_tag" class="sr-only">Select Tags</label>
            <select
              v-model="searchParam.tagMatch"
              id="select_tag"
              class="
                block
                py-2
                px-0
                w-full
                text-sm text-gray-500
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-400 dark:border-gray-600
                focus:outline-none focus:ring-0 focus:border-gray-200
                peer
              "
            >
              <option selected value="any_tag">Match any tag</option>
              <option value="all_tags">Match all tags</option>
            </select>
          </div>
          <div>
            <label for="select_media_types" class="sr-only">
              All Media types
            </label>
            <select 
              v-model="searchParam.mediaType"
              id="select_media_types"
              class="
                block
                py-2
                px-0
                w-full
                text-sm text-gray-500
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-400 dark:border-gray-600
                focus:outline-none focus:ring-0 focus:border-gray-200
                peer
              "
            >
              <option selected value="">All Media types</option>
              <option value="hosted video">Hosted Videos</option>
              <option value="external links">External Links</option>
            </select>
          </div>
        </div>
      </div>
      <div v-if="videoListCheck == 1" class="flex justify-center py-20">
        <!-- spinner state -->
        <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
      </div>
      <!-- main content display -->
      <div v-if="videoListCheck == 2" class="mt-12">
        <!-- pagination -->
        <div>
          <!-- main content display -->
          <div class="grid xl:grid-cols-4 md:grid-cols-2 xl:grid-gap-3 md:grid-gap-2 place-content-center">
            <div v-for="cont in contents.data" :key="cont.id">
              <div
                class="w-72 bg-white rounded-lg border border-gray-200
                shadow-md dark:bg-gray-800 dark:border-gray-700 mb-3"
              >
                <span v-if="cont.file_name.includes('.mp3')" style="height: 170px; background-color:gray">
                  <a class="cursor-pointer" @click="playContent(cont)">
                    <div class="rounded-t-lg bg-gray-900"
                      style="height: 170px;">
                    </div>
                  </a>
                </span>
                <span v-else class="flex">
                  <a :href="cont.file_hash"
                    class="item-center cursor-pointer" data-fancybox>
                    <!-- <video
                      :src="cont.file_hash"
                      class="rounded-t-lg"
                      style="height: 170px;"
                    ></video> -->
                    <img :src="cont.thumbnail" class="rounded-t-lg" style="height: 170px;">
                  </a>
                </span>
                <div class="p-5">
                  <!-- Content Title -->
                  <div class="flex justify-between">
                    <span class="font-normal mb-3 text-sm text-gray-700 dark:text-gray-400" :title="cont.file_name">
                      {{ cont.file_name.replace(/(.{22})..+/, "$1…") +'&nbsp;&nbsp;&nbsp;'}}
                    </span>
                    <span class="font-normal mb-3 text-sm text-gray-700 dark:text-gray-400">
                      {{cont.media_length}}
                    </span>
                  </div>
                  
                  <div class="flex mb-2 justify-center">
                    <!-- Edit video btn -->
                    <div class="rounded-full transition-color cursor-pointer 
                      bg-[rgb(88,80,236)] hover:bg-gray-900 p-1 mr-3 tooltip">
                      <span class="w-1/6 text-white" @click="editVideo(cont)">
                      <span class="tooltiptext">Edit</span>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                          />
                        </svg>
                      </span>
                    </div>
                    <!-- Embed video btn -->
                    <div class="rounded-full transition-color cursor-pointer 
                      bg-[rgb(88,80,236)] hover:bg-gray-900 p-1 mr-3 tooltip">
                      <span class="w-1/6 text-white" @click="embedContent(cont)">
                      <span class="tooltiptext">Embed</span>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"
                          />
                        </svg>
                      </span>
                    </div>
                    <!-- Download video btn -->
                    <div class="rounded-full transition-color cursor-pointer 
                      bg-[rgb(88,80,236)] hover:bg-gray-900 p-1 mr-3 tooltip-download">
                      <span class="w-1/6 text-white" @click.prevent="downloadContent(cont)">
                        <span class="tooltiptext">Download</span>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"
                          />
                        </svg>
                      </span>
                    </div>
                    <!-- Delete video btn -->
                    <div class="rounded-full transition-color cursor-pointer 
                      bg-[rgb(88,80,236)] hover:bg-gray-900 p-1 tooltip">
                      <span class="w-1/6 text-white" @click.prevent="confirmDelete(cont)">
                      <span class="tooltiptext">Delete</span>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          />
                        </svg>
                      </span>
                    </div>
                  </div>
                  <!-- tags section -->
                  <div class="flex mt-2">
                    <div v-if="cont.tags">
                      <div class="grid xl:grid-flow-col auto-cols-max">
                        <div v-for="vTag in cont.tags.split(',')" :key="vTag">
                          <span class="flex bg-blue-100 text-blue-800 text-xs font-medium 
                            mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                            {{vTag}} 
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex justify-center mt-5">
            <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm "
              aria-label="Pagination"
            >
            <a 
              v-for="(link, i) of contents.meta.links" 
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
                i === contents.meta.links.length - 1 ? 'rounded-r-md' : '',
              ]"
              v-html="link.label"
            >
            </a>
            </nav>
          </div>
        </div>
      </div>
      <div v-if="videoListCheck == 3" class="flex justify-center items-center" >
        <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
          <h5 class="text-2xl text-gray-900 dark:text-white">No content available</h5>
          <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
            <img src="../../assets/no_content.png" class="xl:w-82 xl:h-82" />
          </div>
        </div>
      </div>
      <!-- Edit content modal -->
      <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
          </TransitionChild>

          <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
              <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-xl w-full">
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-4 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-9 w-9 rounded-full bg-blue-200 sm:mx-0 sm:h-10 sm:w-10">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-4 w-4"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                          />
                        </svg>
                      </div>
                      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Edit Video </DialogTitle>
                      </div>
                    </div>
                    <div class="sm:items-start">
                        <div class="mt-6 w-full">
                          <div v-if="videoUpdate.contentName !== null" class="share-overlay-container">
                            <!-- audio element -->
                            <!-- <vue-plyr v-if="videoUpdate.contentName.includes('.mp3')" >
                              <audio controls playsinline >
                                <source
                                  :src="videoUpdate.contentUrl"
                                  type="audio/mp3"
                                  class="pt-20"
                                />
                              </audio>
                            </vue-plyr> -->
                            <!-- video element -->
                            <!-- <vue-plyr v-else :options="options">
                              <video
                                controls
                                playsinline
                                data-poster=""
                                class="video-lay"
                              >
                                <source
                                  size="720"
                                  :src="videoUpdate.contentUrl"
                                  type="video/mp4"
                                />
                                <source
                                  size="1080"
                                  :src="videoUpdate.contentUrl"
                                  type="video/mp4"
                                />
                              </video>
                            </vue-plyr> -->
                            <div v-if="editVideoShow == 2">
                              <video-player 
                                :options="videoOptions"
                                :shareOptions="share"
                                :showShare="videoOptionsCustom.share"
                                :showTitle="videoOptionsCustom.title"
                              />
                            </div>
                            <!-- share / embed element -->
                            <div class="mt-3" v-show="sEmbed">
                              <div class="px-4  sm:px-0 sm:flex sm:flex-row-reverse">
                                <span @click="sEmbed = false"
                                  class="w-4 h-4 flex items-center justify-center rounded-full
                                  transition-color cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                  </svg>
                                </span>
                              </div>
                              <div class="bg-gray-200 p-4 place-content-center transition duration-700 ease-in-out">
                                <div class="grid grid-flow-col auto-cols-max">
                                  <div>
                                    <button type="button" 
                                      class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none 
                                      focus:ring-[#3b5998]/50 font-medium  text-sm px-5 py-2.5 text-center 
                                      inline-flex items-center dark:focus:ring-[#3b5998]/55 mr-2 mb-2"
                                      @click="socialShare(videoUpdate.externalUrl,videoUpdate.contentName,'facebook')">
                                      <svg class="w-4 h-4" 
                                        aria-hidden="true" 
                                        focusable="false" 
                                        data-prefix="fab" 
                                        data-icon="facebook-f" 
                                        role="img" 
                                        xmlns="http://www.w3.org/2000/svg" 
                                        viewBox="0 0 320 512"
                                      >
                                        <path fill="currentColor"
                                          d="M279.1 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.4 0 225.4 0c-73.22 0-121.1 44.38-121.1 124.7v70.62H22.89V288h81.39v224h100.2V288z"
                                        ></path>
                                      </svg>Share on Facebook
                                    </button>
                                  </div>
                                  <div>
                                    <button type="button" 
                                      class="text-white bg-[#1da1f2] hover:bg-[#1da1f2]/90 focus:ring-4 focus:outline-none 
                                      focus:ring-[#1da1f2]/50 font-medium text-sm px-5 py-2.5 text-center 
                                      inline-flex items-center dark:focus:ring-[#1da1f2]/55 mr-2 mb-2"
                                      @click="socialShare(videoUpdate.externalUrl,videoUpdate.contentName,'twitter')">
                                      <svg class="w-4 h-4" 
                                        aria-hidden="true" 
                                        focusable="false" 
                                        data-prefix="fab" 
                                        data-icon="twitter" 
                                        role="img" 
                                        xmlns="http://www.w3.org/2000/svg" 
                                        viewBox="0 0 512 512"
                                      >
                                        <path fill="currentColor" 
                                          d="M459.4 151.7c.325 4.548 .325 9.097 .325 13.65 0 138.7-105.6 298.6-298.6 298.6-59.45 0-114.7-17.22-161.1-47.11 8.447 .974 16.57 1.299 25.34 1.299 49.06 0 94.21-16.57 130.3-44.83-46.13-.975-84.79-31.19-98.11-72.77 6.498 .974 12.99 1.624 19.82 1.624 9.421 0 18.84-1.3 27.61-3.573-48.08-9.747-84.14-51.98-84.14-102.1v-1.299c13.97 7.797 30.21 12.67 47.43 13.32-28.26-18.84-46.78-51.01-46.78-87.39 0-19.49 5.197-37.36 14.29-52.95 51.65 63.67 129.3 105.3 216.4 109.8-1.624-7.797-2.599-15.92-2.599-24.04 0-57.83 46.78-104.9 104.9-104.9 30.21 0 57.5 12.67 76.67 33.14 23.72-4.548 46.46-13.32 66.6-25.34-7.798 24.37-24.37 44.83-46.13 57.83 21.12-2.273 41.58-8.122 60.43-16.24-14.29 20.79-32.16 39.31-52.63 54.25z"
                                        ></path>
                                      </svg>Share on Twitter
                                    </button>
                                  </div>
                                  <div></div>
                                </div>
                                <!-- share link items -->
                                <div class="flex">
                                  <span 
                                    class="inline-flex items-center px-3 text-sm text-gray-900 
                                    bg-gray-200 border border-r-0 border-gray-300 rounded-l-md 
                                    dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"
                                  >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" 
                                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                  </span>
                                  <input type="text" id="share-url" 
                                    class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 
                                    text-gray-900 text-xs focus:ring-blue-500 focus:border-blue-500 block flex-1 
                                    min-w-0 w-full border-gray-300 p-2.5 dark:bg-gray-700 
                                    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                                    dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer" 
                                    placeholder="" :value="videoUpdate.externalUrl"
                                    @click="copyData(videoUpdate.externalUrl, 'share-url')" readonly
                                  >
                                </div>
                                <!-- embed content  -->
                                <div class="flex mt-3">
                                  <span 
                                    class="inline-flex items-center px-3 text-sm text-gray-900 
                                    bg-gray-200 border border-r-0 border-gray-300 rounded-l-md 
                                    dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"
                                  >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" 
                                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                  </span>
                                  <textarea name="embed-content" id="embed-content"
                                    rows="3"
                                    class="block p-2.5 w-full text-xs text-gray-900 
                                    bg-gray-50 rounded-lg border border-gray-300 
                                    focus:ring-blue-500 focus:border-blue-500 
                                    dark:bg-gray-700 dark:border-gray-600 
                                    dark:placeholder-gray-400 dark:text-white 
                                    dark:focus:ring-blue-500 dark:focus:border-blue-500 
                                    cursor-pointer" :value="videoUpdate.embededFrame" 
                                    @click="copyData(videoUpdate.embededFrame, 'embed-content')" readonly 
                                  ></textarea>
                                </div>
                              <div>

                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="px-4 py-3 sm:px-0 sm:flex sm:flex-row-reverse">
                            <button type="button" 
                              class="mt-6 w-full inline-flex justify-center  
                              border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                              font-medium text-gray-700 hover:bg-gray-50 focus:outline-none 
                              focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 
                              sm:ml-3 sm:w-auto sm:text-sm" 
                              @click="sEmbed = true" ref="shareButtonRef"
                            >Share / Embed</button>
                          </div> -->
                          
                          <div class="relative z-0 w-full mb-6 group mt-6">
                            <input type="text" name="video-name" id="video-name" v-model="videoUpdate.contentName"
                              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                              border-0 border-b-2 border-gray-300 appearance-none dark:text-white 
                              dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none 
                              focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="video-name"  
                              class="peer-focus:font-medium absolute text-sm text-gray-500 
                              dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 
                              top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                              peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                              peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                              peer-focus:-translate-y-6">Name
                            </label>
                          </div>
                          <div class="relative z-0 w-full mb-6 group mt-3">
                            <input type="text" name="video-tag" id="video-tag" @keyup.enter="passTag" 
                              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                              border-0 border-b-2 border-gray-300 appearance-none dark:text-white 
                              dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none 
                              focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="video-tag"  
                              class="peer-focus:font-medium absolute text-sm text-gray-500 
                              dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 
                              top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                              peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                              peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                              peer-focus:-translate-y-6">Tags
                            </label>
                          </div>
                          <input type="hidden" name="tags" id="tags" v-model="videoUpdate.videoTag">
                        </div>
                        <div v-if="videoUpdate.videoTag.length">
                          <div class="grid xl:grid-col-2 xl:gap-1">
                            <div v-for="vTag in videoUpdate.videoTag" :key="vTag">
                              <div class="flex">
                                <span class="flex bg-blue-100 text-blue-800 text-sm font-medium 
                                  mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                  {{vTag}} &nbsp;
                                  <span @click="removeTag(vTag)"
                                    class="w-4 h-4 flex items-center justify-center rounded-full transition-color cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                  </span>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                          <button type="submit" 
                            class="justify-center py-2 px-4 border 
                            border-transparent text-sm font-medium text-white 
                            bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            sm:ml-3 sm:w-auto sm:text-sm w-full"
                            @click="updateContent"
                          >Save</button>
                          <button type="button" 
                            class="mt-3 w-full justify-center  
                            border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                            font-medium text-gray-700 hover:bg-gray-50 focus:outline-none 
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 
                            sm:ml-3 sm:w-auto sm:text-sm" 
                            @click="open = false" ref="cancelButtonRef"
                          >Cancel</button>
                          
                        </div>
                    </div>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
      <!-- play content modal (audio)-->
      <TransitionRoot as="template" :show="play">
        <Dialog as="div" class="relative z-10" @close="play = false">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-zinc-900 bg-opacity-80 transition-opacity" />
          </TransitionChild>

          <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
              <TransitionChild as="template" enter="ease-out duration-300" 
                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                enter-to="opacity-100 translate-y-0 sm:scale-100" 
                leave="ease-in duration-200" 
                leave-from="opacity-100 translate-y-0 sm:scale-100" 
                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative  text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-xl sm:w-full ">
                  <div class=" p-0">
                    <div class="sm:flex sm:items-start">
                      <!-- px-4 pt-5 pb-4 sm:p-6 sm:pb-4
                      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                      </div> -->
                      <div class="mt-3 text-center sm:mt-0 sm:ml-0 sm:mr-0 sm:text-left">
                        <!-- <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> {{videoUpdate.contentName}} </DialogTitle> -->
                        <div v-if="videoUpdate.contentUrl !== null" >
                          <!-- audio element -->
                          <vue-plyr v-if="videoUpdate.contentName.includes('.mp3')" >
                            <audio controls playsinline autoplay>
                              <source
                                :src="videoUpdate.contentUrl"
                                type="audio/mp3"
                                class="pt-20"
                              />
                            </audio>
                          </vue-plyr>
                          <!-- video element -->
                          <vue-plyr v-else >
                            <video
                              controls
                              playsinline
                              data-poster=""
                              autoplay=1
                            >
                              <source
                                size="720"
                                :src="videoUpdate.contentUrl"
                                type="video/mp4"
                              />
                              <source
                                size="1080"
                                :src="videoUpdate.contentUrl"
                                type="video/mp4"
                              />
                            </video>
                          </vue-plyr>
                        </div>
                      </div>
                    </div>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
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
                <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                      </div>
                      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> 
                          Delete {{videoUpdate.contentName}} 
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
                        @click="deleteContent(videoUpdate.contentId)" :disabled="isDisabled"
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
      <!-- embed content -->
      <TransitionRoot as="template" :show="openEmbed">
        <Dialog as="div" class="relative z-10" @close="openEmbed = false">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
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
                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Embed Video </DialogTitle>
                      </div>
                    </div>
                    <div class="sm:items-start">
                      <div class="mt-2">
                        <div v-if="videoUpdate.contentName !== null" class="share-overlay-container">
                          <!-- audio element -->
                          <!-- <vue-plyr v-if="videoUpdate.contentName.includes('.mp3')" >
                            <audio controls playsinline >
                              <source
                                :src="videoUpdate.contentUrl"
                                type="audio/mp3"
                                class="pt-20"
                              />
                            </audio>
                          </vue-plyr> -->
                          <!-- video element -->
                          <!-- <vue-plyr v-else :options="options">
                            <video
                              controls
                              playsinline
                              data-poster=""
                              class="video-lay"
                            >
                              <source
                                size="720"
                                :src="videoUpdate.contentUrl"
                                type="video/mp4"
                              />
                              <source
                                size="1080"
                                :src="videoUpdate.contentUrl"
                                type="video/mp4"
                              />
                            </video>
                          </vue-plyr> -->
                          <div v-if="embedVideoShow == 2">
                            <video-player 
                              :options="videoOptions"
                              :shareOptions="share"
                              :showShare="videoOptionsCustom.share"
                              :showTitle="videoOptionsCustom.title"
                            />
                          </div>
                        </div>
                        <!-- embed settings/twerks -->
                        <div class="grid xl:grid-cols-3 gap-3 mt-4">
                          <div>
                            <h3 class="font-bold text-lg text-gray-900">Size</h3>
                            <div class="flex mt-3">
                              <div class="flex items-center mr-4">
                                <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                <input
                                  type="radio"
                                  v-model="embedFilters.isPicked"
                                  value="responsive" 
                                  name="inline-radio-group" 
                                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 
                                  dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                  dark:border-gray-600"
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
                                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 
                                  dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                  dark:border-gray-600"
                                >
                                Fixed</label>
                              </div>
                            </div>
                            <div v-if="embedFilters.isPicked == 'responsive'" class="mt-5">
                              <select
                                v-model="embedFilters.ratio"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm 
                                focus:ring-blue-500 focus:border-blue-500 block xl:w-1/2 p-2.5  
                                w-1/2">
                                <option value="56.25%">16:9</option>
                                <option value="75%">4:3</option>
                                <option value="100%">1:1</option>
                              </select>
                              <label class="block mb-2 mt-2  text-sm font-medium text-gray-900 dark:text-gray-400">
                                Aspect Ratio
                              </label>
                            </div>
                            <div v-else class="mt-5">
                              <div class="grid grid-cols-3 gap-1">
                                <div>
                                  <div class="">
                                    <input type="text" id="width" v-model="embedFilters.pixelWid"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm 
                                      focus:ring-blue-500 focus:border-blue-500 block w-full 
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
                                      focus:ring-blue-500 focus:border-blue-500 block w-full 
                                      p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                      dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                  </div>
                                </div>
                              </div>
                              <label class="block mb-2 mt-2 text-sm font-medium text-gray-900 dark:text-gray-400">Pixels</label>
                            </div>
                          </div>
                          <div>
                            <h3 class="font-bold text-lg text-gray-900">Playback options</h3>
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
                            <h3 class="font-bold text-lg text-gray-900">Display options</h3>
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
                        <div class="mt-5">
                          <button type="button" 
                            class="group relative flex justify-center py-2 px-4 border 
                            border-transparent text-sm font-medium text-white 
                            bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            sm:w-auto sm:text-sm w-full"
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
                      class="mt-3 w-full inline-flex justify-center border border-gray-300 
                      shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 
                      hover:bg-gray-50 focus:outline-none focus:ring-offset-2 
                      focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" 
                      @click="openEmbed = false" ref="cancelButtonRef"
                    >Cancel</button>
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
import PageComponent from "../../components/PageComponent.vue";
// import EmbedModal from "../../components/EmbedModal.vue";
import store from "../../store";
import Notification from '../../components/Notification.vue';
import VideoPlayer from '../../components/VideoPlayer2.vue';
import { ref, onMounted, getCurrentInstance, computed, watch } from "vue";
import { useRouter, useRoute } from 'vue-router';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationIcon } from '@heroicons/vue/outline'
import { Fancybox, Carousel, Panzoom } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";

const internalInstance = getCurrentInstance();
const contents = computed(() => store.state.contents);
const router = useRouter();
const route = useRoute();

const openDelete = ref(false)
const open = ref(false)
const play = ref(false)
const sEmbed = ref(false)
const openEmbed = ref(false)
const videoListCheck = ref(0)

let isDisabled = ref(false)
let externalLink = ref('')
let editVideoShow = ref(0)
let embedVideoShow = ref(0)

let videoUpdate = ref({
  contentName: null,
  contentId: null,
  contentUrl: '',
  externalUrl: '',
  embededFrame: '',
  videoTag: []
})

const searchParam = ref({
  name: null,
  tag: null,
  tagMatch: 'any_tag',
  mediaType: ''
})

// player setting 
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
  fbAppId: '74883939828939939900',
  // optional for Facebook
  redirectUri: window.location.href + '#close',

  // optional for VK
  isVkParse: true,

  // optinal embed code
  embedCode : ''
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
})
const code = ref('')

watch(embedFilters, (after, before) => {
  embedCode(after)
}, {deep: true})

watch(searchParam, (after, before) => {
  setTimeout(function(){
    searchContent(after)
  }, 2000)
}, {deep: true})

const embedCode = (item) => {
  if(item.isPicked == 'responsive') {
    code.value = `<div style='position: relative; padding-bottom: ${item.ratio}; height: 0;'><iframe src='${videoUpdate.value.embededFrame}?autoplay=${item.isAutoPlay == true ? 1 : 0}&volume=${item.isVolume == true ? 1 : 0}&controls=${item.sControls == true ? 1 : 0}&title=${item.sContentTitle == true ? 1 : 0}&share=${item.sShare == true ? 1 : 0}' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%;' frameborder='0' allow='autoplay' allowfullscreen></iframe></div>`
  }else {
    code.value = `<iframe src='${videoUpdate.value.embededFrame}?autoplay=${item.isAutoPlay == true ? 1 : 0}&volume=${item.isVolume == true ? 1 : 0}&controls=${item.sControls == true ? 1 : 0}&title=${item.sContentTitle == true ? 1 : 0}&share=${item.sShare == true ? 1 : 0}' width='${item.pixelWid}' height='${item.pixelLen}' frameborder='0' allow='autoplay' allowfullscreen></iframe>`
  }
}

// embed content  
const embedContent = (cont) => {
  const embedUrl = router.resolve({
    name: 'EmbedVideo',
    params: { str: cont.external_link}
  });
  const shareUrl = router.resolve({
    name: 'ShareVideo',
    params: { str: cont.external_link}
  });
  videoUpdate.value.contentName = cont.file_name
  videoUpdate.value.contentId = cont.id
  videoUpdate.value.contentUrl = cont.file_hash // image and player
  videoUpdate.value.externalUrl = `https://${window.location.host+shareUrl.href}` // external sharing
  videoUpdate.value.embededFrame = `https://${window.location.host+embedUrl.href}`
  openEmbed.value = true;
  code.value = `<div style='position: relative; padding-bottom: ${embedFilters.value.ratio}; height: 0;'><iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&controls=1&title=1&share=1' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%;' frameborder='0' allow='autoplay' allowfullscreen></iframe></div>`
  
  // videojs player
  videoOptions.value.sources[0].src = cont.file_hash;
  share.value.url = `https://${window.location.host+shareUrl.href}`;
  share.value.embedCode = `<iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`;
  share.value.title = `Watch "${cont.file_name}" on `;
  embedVideoShow.value = 2;
}

const searchContent = async (item) => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch("searchContent", item)
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

const queryContentLink = async (ev) => {
  ev.preventDefault();
  store
    .dispatch('queryContentLink', {reference: externalLink.value})
    .then((res) => {
      console.log(res)
    })
    .catch(err => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      isDisabled.value = false;
      console.log(err)

      // if(err.response.data) {
      //   if (err.response.data.hasOwnProperty('message')){
      //     errorMsg.value = err.response.data.message
      //   }else {
      //     errorMsg.value = err.response.data.error
      //   }
      // }
    })
}

const addExternalContent = async (ev) => {
  ev.preventDefault();
  isDisabled.value = true;

  if ( !isValidURL(externalLink.value) || !externalLink.value.includes('.m3u8')) {
    store.dispatch("setErrorNotification", 'Insert a valid URL, example: "https://yourcdn.com/video.m3u8".');
    isDisabled.value = false;
    return false;
  }
  internalInstance.appContext.config.globalProperties.$Progress.set(30);
  await store
    .dispatch('addExternalContent', {link: externalLink.value})
    .then((res) => {
      externalLink.value = '';
      isDisabled.value = false;
      store.dispatch("setSuccessNotification", res.status);
      store.dispatch("getContents")
      internalInstance.appContext.config.globalProperties.$Progress.finish();
    })
    .catch(err => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      isDisabled.value = false;

      if(err.response.data) {
        if (err.response.data.hasOwnProperty('message')){
          store.dispatch("setErrorNotification", err.response.data.message);
        }else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    })
}

// Get all contents 
const getContents = async () => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  videoListCheck.value = 1;
  await store
    .dispatch("getContents")
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      if(res.data.length)
        videoListCheck.value = 2
      else
        videoListCheck.value = 3
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      videoListCheck.value = 3
      if (err.response.data) {
        if (err.response.data.hasOwnProperty("message")) {
          store.dispatch("setErrorNotification", err.response.data.message);
        } else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    });
};

// Update content
const updateContent = async (ev) => {
  ev.preventDefault();
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch('updateContent', {
      contentName: videoUpdate.value.contentName,
      contentId: videoUpdate.value.contentId,
      videoTag: videoUpdate.value.videoTag.toString()
    })
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      open.value = false;
      store.dispatch("getContents")
      store.dispatch("setSuccessNotification", res.status);
    })
    .catch(err => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      open.value = false
      console.log(err)
      if(err.response) {
        if (err.response.data.hasOwnProperty('message')){
          store.dispatch("setErrorNotification", err.response.data.message);
        }else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    })
}

// download content 
const downloadContent = async (cont) => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch("downloadContent", cont.id)
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      let fileExt = cont.file_hash.replace(`${import.meta.env.VITE_API_BASE_URI}/uploads/`, '');
      forceFileDownload(res, cont.file_name, fileExt.split('.')[1])
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();

      if (err.response.data) {
        if (err.response.data.hasOwnProperty('message')){
          store.dispatch("setErrorNotification", err.response.data.message);
        }else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    });
}

// delete content
const deleteContent = async (id) => { 
  isDisabled.value = true ;
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch("deleteContent", id)
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      store.dispatch("setSuccessNotification", res.message);
      isDisabled.value = false
      openDelete.value = false
      store.dispatch("getContents")
    })
    .catch((err) => {
      isDisabled.value = false 
      openDelete.value = false
      internalInstance.appContext.config.globalProperties.$Progress.fail();

      if (err.response.data) {
        if (err.response.data.hasOwnProperty('message')){
          store.dispatch("setErrorNotification", err.response.data.message);
        }else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    });
}

const confirmDelete = (cont) => {
  openDelete.value = true;
  videoUpdate.value.contentId = cont.id
  videoUpdate.value.contentName = cont.file_name
}

// Handles edit video click 
const editVideo = (cont) => {
  const shareUrl = router.resolve({
    name: 'ShareVideo',
    params: { str: cont.external_link}
  });
  const embedUrl = router.resolve({
    name: 'EmbedVideo',
    params: { str: cont.external_link}
  });
  videoUpdate.value.contentName = cont.file_name
  videoUpdate.value.contentId = cont.id
  videoUpdate.value.contentUrl = cont.file_hash // image and player
  videoUpdate.value.externalUrl = `https://${window.location.host+shareUrl.href}` // external sharing
  videoUpdate.value.embededFrame = `<iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`
  sEmbed.value = false

  // videojs player
  videoOptions.value.sources[0].src = cont.file_hash;
  share.value.url = `https://${window.location.host+shareUrl.href}`;
  share.value.embedCode = `<iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`;
  share.value.title = `Watch "${cont.file_name}" on `;
  editVideoShow.value = 2;

  if(cont.tags == null) {
    videoUpdate.value.videoTag = []
  }else {
    videoUpdate.value.videoTag = []
    for (let t of  cont.tags.split(',')) {
      videoUpdate.value.videoTag.push(t)
    }
  }
  open.value = true;
}

// Watch video/Audio on click 
const playContent = (cont) => {
  videoUpdate.value.contentName = cont.file_name
  videoUpdate.value.contentUrl = cont.file_hash
  if (videoUpdate.value.contentUrl !== null)
    play.value = true;
}

// Handles tag passing to array 
const passTag = () => {
  let tag = document.getElementById('video-tag');
  videoUpdate.value.videoTag.push(tag.value);
  tag.value = '';
}

const removeTag = (vTag) => {
  let filtered = videoUpdate['_rawValue'].videoTag.filter(data => data != vTag)

  videoUpdate.value.videoTag = [];

  for (let f of filtered) {
    videoUpdate.value.videoTag.push(f)
  }
}

// copy to clipboard
const copyData = (data, elmId) => {
  document.getElementById(elmId).select()
  navigator.clipboard.writeText(data);
  alert("Copied to clipboard!");
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

const forceFileDownload = (response, filename, fhash) => {
  const url = window.URL.createObjectURL(new Blob([response]))
  const link = document.createElement('a')
  link.href = url
  link.setAttribute('download', `${filename}.${fhash}`) //or any other extension
  document.body.appendChild(link)
  link.click()
}

const getForPage = (ev,link) => {
  ev.preventDefault();
  if(!link.url || link.active) {
    return;
  }

  store.dispatch("getContents", {url: link.url})
}

const isValidURL = (string) => {
  var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
  return (res !== null)
};

onMounted(() => {
  getContents();
});
</script>

<style scoped>
.tooltip {
  position: relative;
}
.tooltip-download {
  position: relative;
}
.tooltip .tooltiptext {
  visibility: hidden;
  min-width: 55px;
  background-color: #000000;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 130%;
  left: 220%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}
.tooltip-download .tooltiptext {
  visibility: hidden;
  min-width: 55px;
  background-color: #000000;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 130%;
  left: 170%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}
.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #000000 transparent transparent transparent;
}
.tooltip-download .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #000000 transparent transparent transparent;
}
.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
.tooltip-download:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>