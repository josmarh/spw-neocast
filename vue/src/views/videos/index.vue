<template>
  <div>
    <page-component title="Contents">
      <div v-if="successMsg">
        <div id="toast-success" class="absolute flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 divide-x divide-gray-200 right-5 top-10" role="alert">
          <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
          </div>
          <div class="ml-3 text-sm font-normal">{{successMsg}}</div>
          <button type="button" @click="successMsg=''"
              class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" 
              data-dismiss-target="#toast-success" 
              aria-label="Close">
              <span class="sr-only">Close</span>
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </div>
      </div>
      <div v-else-if="errorMsg">
        <!-- <error-notification :message="errorMsg"></error-notification> -->
        <div id="toast-error" class="absolute flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 divide-x divide-gray-200 right-5 top-10" role="alert">
          <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
              <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </div>
          </div>
          <div class="ml-3 text-sm font-normal">{{errorMsg}}</div>
          <button type="button" @click="errorMsg=''"
              class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" 
              data-dismiss-target="#toast-error" 
              aria-label="Close">
              <span class="sr-only">Close</span>
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </div>
      </div>
      <!-- upload or import via link section -->
      <div class="flex justify-center items-center w-full mb-3">
        <div class="grid xl:grid-cols-5 xl:gap-2">
          <div class="mb-3">
            <router-link
              :to="{ name: 'Uploads' }"
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
                type="url"
                id="video-url"
                class="
                  block
                  py-3
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
              />
              <label
                for="video-url"
                class="
                  absolute
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
                >Video URL (.m3u8 link)
              </label>
            </div>
          </div>
          <div>
            <button
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
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-5 h-5 text-gray-500 dark:text-gray-400"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
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
              <option disabled selected hidden>Match any tag</option>
              <option value="any_tag">Match any tag</option>
              <option value="all_tags">Match all tags</option>
            </select>
          </div>
          <div>
            <label for="select_media_types" class="sr-only"
              >All Media types</label
            >
            <select
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
              <option disabled selected hidden>All Media types</option>
              <option value="hosted_videos">Hosted Videos</option>
              <option value="external_links">External Links</option>
            </select>
          </div>
        </div>
      </div>
      <!-- main content display -->
      <div class="mt-12">
        <div class="grid xl:grid-cols-4 md:grid-cols-2 xl:grid-gap-3 md:grid-gap-2 place-content-center">
          <div v-for="cont in contents" :key="cont.id">
            <div
              class="
                w-72
                bg-white
                rounded-lg
                border border-gray-200
                shadow-md
                dark:bg-gray-800 dark:border-gray-700
                mb-3
              "
            >
              <span v-if="cont.file_name.includes('.mp3')" style="height: 170px; background-color:gray">
                <a href="#">
                  <div class="rounded-t-lg bg-gray-900"
                    style="height: 170px;">
                  </div>
                </a>
              </span>
              <span v-else class="flex">
                <a href="#" class="item-center">
                  <video
                    :src="`http://localhost:8000/${cont.file_hash}`"
                    class="rounded-t-lg"
                    style="height: 170px;"
                  ></video>
                </a>
              </span>
              <div class="p-5">
                <div class="flex mb-2 justify-center">
                  <!-- Edit video -->
                  <div class="rounded-full transition-color cursor-pointer bg-[rgb(88,80,236)] hover:bg-gray-900 p-1 mr-3 tooltip-default">
                    <span class="w-1/6 text-white" @click="editVideo(cont)">
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
                  <!-- Embed video -->
                  <div class="rounded-full transition-color cursor-pointer bg-[rgb(88,80,236)] hover:bg-gray-900 p-1 mr-3">
                    <span class="w-1/6 text-white">
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
                  <!-- Download video -->
                  <div class="rounded-full transition-color cursor-pointer bg-[rgb(88,80,236)] hover:bg-gray-900 p-1 mr-3">
                    <span class="w-1/6 text-white">
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
                  <!-- Delete video -->
                  <div class="rounded-full transition-color cursor-pointer bg-[rgb(88,80,236)] hover:bg-gray-900 p-1">
                    <span class="w-1/6 text-white">
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
                <p class="font-normal text-sm text-gray-700 dark:text-gray-400" :title="cont.file_name">
                  {{ cont.file_name.replace(/(.{27})..+/, "$1…") +'&nbsp;&nbsp;&nbsp;'+cont.media_length}}
                </p>
                <!-- tags section -->
                <!-- <div class="flex mt-2" v-if="cont.file_name == videoUpdate.contentName">
                  <div v-if="videoUpdate.videoTag.length">
                    <div class="grid xl:grid-cols-3 xl:gap-1">
                      <div v-for="vTag in videoUpdate.videoTag" :key="vTag">
                        <div class="">
                          <span class="flex bg-blue-100 text-blue-800 text-sm font-medium 
                            mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                            {{vTag}}
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
                <div class="flex mt-2">
                  <div v-if="cont.tags">
                    <div class="grid xl:grid-cols-2 xl:gap-1">
                      <div v-for="vTag in cont.tags.split(',')" :key="vTag">
                        <span class="flex bg-blue-100 text-blue-800 text-sm font-medium 
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
      </div>
      <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
          </TransitionChild>

          <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
              <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-200 sm:mx-0 sm:h-10 sm:w-10">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-5 w-5"
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
                        
                          <!-- <form> -->
                            <div class="mt-6 w-96">
                              <div class="relative z-0 w-full mb-6 group mt-3">
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
                              <div class="grid xl:grid-col-3 xl:gap-1">
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
                                class="group relative flex justify-center py-2 px-4 border 
                                border-transparent text-sm font-medium text-white 
                                bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                                sm:ml-3 sm:w-auto sm:text-sm"
                                @click="updateContent"
                              >Save</button>
                              <button type="button" 
                                class="mt-3 w-full inline-flex justify-center  
                                border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                                font-medium text-gray-700 hover:bg-gray-50 focus:outline-none 
                                focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 
                                sm:ml-3 sm:w-auto sm:text-sm" 
                                @click="open = false" ref="cancelButtonRef"
                              >Cancel</button>
                            </div>
                          <!-- </form> -->
                        
                      </div>
                    </div>
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
import store from "../../store";
import { ref, onMounted, getCurrentInstance, computed } from "vue";
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationIcon } from '@heroicons/vue/outline'

const internalInstance = getCurrentInstance();
const contents = computed(() => store.state.contents.contents);
const open = ref(false)

let errorMsg = ref("");
let successMsg = ref('');
let videoUpdate = ref({
  contentName: null,
  contentId: null,
  videoTag: []
})

// Get all contents 
const getContents = async () => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch("getContents")
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.finish();
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();

      if (err.response.data) {
        if (err.response.data.hasOwnProperty("message")) {
          errorMsg.value = err.response.data.message;
        } else {
          errorMsg.value = err.response.data.error;
        }
      }
    });
};

// Handles edit video click 
const editVideo = (cont) => {
  videoUpdate.value.contentName = cont.file_name
  videoUpdate.value.contentId = cont.id
  let vidName = document.getElementById('video-name')

  if(cont.tags == null) {
    videoUpdate.value.videoTag = []
  }else {
    videoUpdate.value.videoTag = []
    for (let t of  cont.tags.split(',')) {
      videoUpdate.value.videoTag.push(t)
    }
  }
  open.value = true
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

// Update content
const updateContent = async (ev) => {
  ev.preventDefault();
  internalInstance.appContext.config.globalProperties.$Progress.start();
  store
    .dispatch('updateContent', {
      contentName: videoUpdate.value.contentName,
      contentId: videoUpdate.value.contentId,
      videoTag: videoUpdate.value.videoTag.toString()
    })
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      open.value = false;
      successMsg.value = res.status;
      getContents();
    })
    .catch(err => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      open.value = false
      console.log(err)
      if(err.response) {
        if (err.response.data.hasOwnProperty('message')){
          errorMsg.value = err.response.data.message
        }else {
          errorMsg.value = err.response.data.error
        }
      }
    })
  
}

onMounted(() => {
  getContents();
});
</script>

<style scoped>
</style>