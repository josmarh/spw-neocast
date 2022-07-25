<template>
    <div>
        <page-component title="Live Streams" >
            <notification />
            <div class="mb-5">
                <button @click="embedContent"
                    class="text-white bg-gray-400 hover:bg-gray-500 
                    focus:outline-none focus:ring-gray-300 
                    font-medium text-sm w-full sm:w-auto px-4 py-2
                    text-center inline-flex"
                >   
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="h-4 w-4 mr-1" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor" 
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    Embed
                </button>
            </div>
            <!-- main section -->
            <div class="grid xl:grid-cols-12 xl:gap-6">
                <div class="col-span-6">
                    <div v-if="streamStatus == 1" class="flex justify-center py-20">
                        <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" 
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                    </div>
                    <div v-if="streamStatus == 2">
                        <video-player 
                            :options="videoOptions"
                            :shareOptions="share"
                            :showShare="videoOptionsCustom.share"
                            :showTitle="videoOptionsCustom.title"
                        />
                    </div>
                    <div v-if="streamStatus == 3">
                        <div class="p-20 w-full bg-black border shadow-md sm:p-36 dark:bg-gray-800 dark:border-gray-700 text-center">
                            <span class="text-red-700 font-medium font-bold text-4xl">OFFLINE</span>
                        </div>
                    </div>
                    <div class="p-4 w-full mt-8 bg-white border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Streaming Settings</h5>
                        <div class="flex mt-6">
                            <div class="relative w-full">
                                <label for="rtmp-url" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-gray-300 font-bold">RTMP URL
                                </label>
                                <input type="text" id="rtmp-url" v-model="model.rtmpUrl"
                                    class="block p-2.5 w-full z-20 text-sm text-gray-900 
                                    bg-gray-50 border border-gray-300 
                                    dark:placeholder-gray-400 dark:text-white 
                                    dark:focus:border-indigo-500" 
                                    placeholder="" required="" readonly>
                                <div class="tooltip">
                                    <button type="button" @click="copyData(model.rtmpUrl,'rtmp-url','rtmp-tip')"
                                        class="absolute bottom-0 right-0 p-2.5 text-sm font-medium 
                                        text-white bg-indigo-600 border border-indigo-700 
                                        hover:bg-indigo-800 dark:bg-indigo-600 dark:hover:bg-indigo-700">
                                        <span class="tooltiptext" id="rtmp-tip">Copy</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6" fill="none" 
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex mt-6">
                            <div class="relative w-full">
                                <label for="stream-key" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-gray-300 font-bold">Stream Key
                                </label>
                                <input type="text" id="stream-key" v-model="model.streamKey"
                                    class="block p-2.5 w-full z-20 text-sm text-gray-900 
                                    bg-gray-50 border border-gray-300 
                                    dark:placeholder-gray-400 dark:text-white 
                                    dark:focus:border-indigo-500" 
                                    placeholder="" required="" readonly>
                                <div class="tooltip">
                                    <button type="button" @click="copyData(model.streamKey,'stream-key','stream-tip')"
                                        class="absolute bottom-0 right-0 p-2.5 text-sm font-medium 
                                        text-white bg-indigo-600 border border-indigo-700 
                                        hover:bg-indigo-800 dark:bg-indigo-600 dark:hover:bg-indigo-700">
                                        <span class="tooltiptext" id="stream-tip">Copy</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6" fill="none" 
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-6">
                    <div class="p-4 w-full bg-white border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Basics</h5>
                        <div class="flex mt-6">
                            <div class="relative z-0 xl:w-full sm:w-full md:w-half">
                                <input
                                    type="text"
                                    id="title"
                                    v-model="model.title"
                                    class="block py-2 px-0 xl:w-full sm:w-full md:w-half
                                        text-sm text-gray-900 bg-transparent
                                        border-0 border-b-2 border-gray-300
                                        appearance-none dark:text-white dark:border-gray-600 
                                        dark:focus:border-blue-500 focus:outline-none 
                                        focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" "
                                />
                                <label
                                for="title"
                                class="absolute text-sm text-gray-500
                                    dark:text-gray-400 duration-300 transform
                                    -translate-y-6 scale-75 top-3 -z-10
                                    origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                    peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                    peer-focus:-translate-y-6
                                "
                                >Title
                                </label>
                            </div>
                            <button type="button" @click="updateStream"
                                class="group relative flex justify-center
                                py-2 px-3 border border-transparent
                                text-sm font-medium text-white
                                bg-indigo-600 hover:bg-indigo-700
                                focus:outline-none"
                                >
                                Save
                            </button>
                        </div>
                    </div>
                    <div class="p-4 w-full mt-8 bg-white border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Destinations</h5>
                        <div class="flex flex-nowrap">
                            <div>
                                <button type="button" @click="getChannelList"
                                    class="group relative flex justify-center
                                    py-2 px-3 border border-transparent
                                    text-sm font-medium text-white
                                    bg-indigo-600 hover:bg-indigo-700
                                    focus:outline-none mt-4"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Channel
                                </button>
                            </div>
                            <div>
                                <!-- <label for="small-toggle" class="inline-flex relative items-center mb-5 cursor-pointer ml-4 mt-6">
                                    <input type="checkbox" value="" id="small-toggle" class="sr-only peer" 
                                        v-model="model.bsignal" @change="broadcastSignal">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                                        rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full 
                                        peer-checked:after:border-white after:content-[''] after:absolute 
                                        after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 
                                        after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                                        dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                </label> -->
                            </div>
                        </div>

                        <p class="text-sm mt-6" v-if="!model.channel.length"><em>No channel added yet</em></p>
                        <div class="mt-6" v-if="model.channel.length">
                            <ul class="w-auto text-sm text-gray-900 bg-white border border-gray-200  dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li v-for="c in model.channel" :key="c.id"
                                    class="w-full px-4 py-1 border-b border-gray-200 rounded-t-lg dark:border-gray-600 inline-flex justify-between">
                                    <p class="pt-1">{{c.title}}</p>
                                    <span class="content-right">
                                        <button type="button"
                                            @click="removeChannel(c.id)"
                                            class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                            focus:outline-none focus:ring-gray-100 
                                            text-sm px-2 py-2 text-center 
                                            inline-flex items-center dark:focus:ring-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-4 w-full mt-8 bg-white border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Latest Live Streams</h5>
                        <p class="text-sm mt-6" v-if="!model.latestStreams.length"><em>No live streams recorded yet.</em></p>
                        <div class="mt-6" v-if="model.latestStreams.length">
                            <ul class="w-auto text-sm text-gray-900 bg-white border border-gray-200  dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li v-for="c in model.latestStreams" :key="c.id"
                                    class="w-full px-4 py-1 border-b border-gray-200 rounded-t-lg dark:border-gray-600 inline-flex justify-between">
                                    
                                    <p class="pt-1 flex">
                                        <img :src="c.thumbnail" :alt="c.file_name" class="h-10 mr-3">
                                        <span class="mt-2">{{c.file_name}}</span>
                                    </p>
                                    <span class="content-right mt-3">
                                        {{c.media_length}}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- channel list -->
            <TransitionRoot as="template" :show="openChannelList">
                <Dialog as="div" class="relative z-10" @close="openChannelList = false">
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
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> 
                                        Send the live feed to these channels 
                                    </DialogTitle>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div v-if="isChannelSet == 1" class="flex justify-center py-20">
                                    <!-- spinner state -->
                                    <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" 
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                </div>
                                <div v-if="isChannelSet == 2">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="p-4">
                                                    <div class="flex items-center">
                                                        <input 
                                                        id="checkbox-all-channel" 
                                                        type="checkbox" 
                                                        v-model="checkboxAllChannel"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 
                                                        border-gray-300 rounded dark:bg-gray-700 
                                                        dark:border-gray-600">
                                                        <label for="checkbox-all-channel" class="ml-3">Select All</label>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="c in channelList.data" :key="c.id">
                                                <td class="p-4">
                                                    <div class="flex items-center">
                                                        <input type="checkbox" :value="c.id" v-model="checkedChannelToAdd" 
                                                        :id="`channel-${c.id}`"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100
                                                        border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                                        <label :for="`channel-${c.id}`" class="ml-3">{{c.title}}</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" 
                                class="mt-3 w-full inline-flex justify-center border 
                                border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                                font-medium text-gray-700 hover:bg-gray-50 focus:outline-none 
                                sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" 
                                @click="openChannelList = false" ref="cancelButtonRef"
                            >Cancel</button>
                            <button type="button" @click="addChannel"
                                class="text-white bg-blue-700 hover:bg-blue-800 
                                focus:outline-none focus:ring-blue-300 
                                font-medium text-sm w-full sm:w-auto px-5 py-2.5 
                                text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                                dark:focus:ring-blue-800" :disabled="isDisabled"
                            >Accept</button>
                        </div>
                        </DialogPanel>
                    </TransitionChild>
                    </div>
                </div>
                </Dialog>
            </TransitionRoot>
            <!-- embed modal -->
            <TransitionRoot as="template" :show="openEmbedCode">
                <Dialog as="div" class="relative z-10" @close="openEmbedCode = false">
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
                                <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[55rem] sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" 
                                                    class="h-4 w-4 mr-1" 
                                                    fill="none" 
                                                    viewBox="0 0 24 24" 
                                                    stroke="currentColor" 
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                                </svg>
                                            </div>
                                            <div class="mt-6 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900 mt-2"> Embed Live Stream </DialogTitle>
                                            </div>
                                        </div>
                                        <div v-if="streamStatus == 1" class="flex justify-center py-20">
                                            <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" 
                                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                            </svg>
                                        </div>
                                        <div v-if="streamStatus == 2" class="mt-4">
                                            <video-player 
                                                :options="videoOptions"
                                                :shareOptions="share"
                                                :showShare="videoOptionsCustom.share"
                                                :showTitle="videoOptionsCustom.title"
                                            />
                                        </div>
                                        <div v-if="streamStatus == 3" class="mt-4">
                                            <div class="p-20 w-full bg-black border shadow-md sm:p-36 dark:bg-gray-800 dark:border-gray-700 text-center">
                                                <span class="text-red-700 font-medium font-bold text-4xl">OFFLINE</span>
                                            </div>
                                        </div>
                                        <!-- embed settings/twerks -->
                                        <div class="grid grid-cols-3 gap-3 mt-4">
                                            <div>
                                                <h3 class="font-bold text-gray-900">Size</h3>
                                                <div class="flex mt-3">
                                                    <div class="flex items-center mr-4">
                                                        <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                        <input
                                                            type="radio"
                                                            v-model="embedFilters.isPicked"
                                                            value="responsive" 
                                                            name="inline-radio-group" 
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 mr-2"
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
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 mr-2"
                                                        >
                                                        Fixed</label>
                                                    </div>
                                                </div>
                                                <div v-if="embedFilters.isPicked == 'responsive'" class="mt-5">
                                                    <select
                                                        v-model="embedFilters.ratio"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm 
                                                        focus:ring-blue-500 focus:border-blue-500 block xl:w-1/2 p-2.5 dark:bg-gray-700 
                                                        dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                                                        dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    >
                                                        <option value="56.25%">16:9</option>
                                                        <option value="75%">4:3</option>
                                                        <option value="100%">1:1</option>
                                                    </select>
                                                    <label class="block mb-2 mt-2 text-sm font-medium text-gray-900 dark:text-gray-400">
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
                                                <h3 class="font-bold text-gray-900">Playback options</h3>
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
                                                            dark:text-gray-300">Autoplay (if possible)
                                                        </label>
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
                                                            dark:text-gray-300">Volume
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900">Display options</h3>
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
                                                            dark:text-gray-300">Show controls
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- embed code field -->
                                        <div class="mt-8">
                                            <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                                                Code
                                            </label>
                                            <textarea 
                                                id="code"
                                                rows="4"
                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50  
                                                border border-gray-300 focus:ring-blue-500 focus:border-blue-500 
                                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                                placeholder=""
                                                v-model="code"
                                            ></textarea>
                                        </div>
                                        <div class="mt-5">
                                            <div class="tooltip-embed">
                                                <button type="button" 
                                                    class="group relative flex justify-center py-2 px-4 border 
                                                    border-transparent text-sm font-medium text-white 
                                                    bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                                                    sm:w-auto sm:text-sm"
                                                    @click="copyData(code, 'code', 'embed-tip')"
                                                >
                                                    <!-- <span class="tooltiptext" id="embed-tip">Copy</span> -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                                    </svg>&nbsp;
                                                    Copy embed code
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="button" 
                                            class="mt-3 w-full inline-flex justify-center 
                                            border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                                            font-medium text-gray-700 hover:bg-gray-50 focus:outline-none 
                                            focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 
                                            sm:ml-3 sm:w-auto sm:text-sm"
                                            @click="openEmbedCode = false" ref="cancelButtonRef">Cancel
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
import VideoPlayer from '../../components/VideoPlayer3.vue';
import { ref, computed, watch, onMounted, onUnmounted, getCurrentInstance } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { useRouter, useRoute } from 'vue-router';

const channelList  = computed(() => store.state.channels);
const router = useRouter();
const route = useRoute();
const internalInstance = getCurrentInstance();
const isChannelSet = ref(0);
const openChannelList = ref(false);
const openEmbedCode = ref(false);
const isDisabled = ref(false);

let model = ref({
    id: null,
    channel: [],
    title: '',
    bsignal: false,
    record_stream: null,
    streamKey: '',
    rtmpUrl: `${import.meta.env.VITE_RTMP_URI}/app`,
    liveStatus: '',
    latestStreams: []
});
let checkboxAllChannel = ref(false);
let checkedChannelToAdd = ref([]);
let tmpChannelList = ref({data: []});
let tmpChannelModel = ref([]);
let embedFilters = ref({
  isPicked: 'responsive',
  ratio: '56.25%',
  pixelWid: '640',
  pixelLen: '360',
  isAutoPlay: false,
  isVolume: true,
  sControls: true,
})
let embedVideoShow = ref(0)
let embedLink = ref('')
let shareLink = ref('')
const code = ref('')
const videoOptions = ref({
    autoplay: false,
    controls: true,
    muted: true,
    loop: false,
    sources: [
        {
        //   src: 'https://d2zihajmogu5jn.cloudfront.net/bipbop-advanced/bipbop_16x9_variant.m3u8',
            src: '',
            type: 'application/x-mpegURL',
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

watch(embedFilters, (after, before) => {
    embedCode(after)
}, {deep: true})

watch(checkboxAllChannel, (after, before) => {
    if(after == true) {
        checkedChannelToAdd.value = [];
        for(let c of tmpChannelList.value.data) {
            checkedChannelToAdd.value.push(c.id);
        }
    }else if(after == false && checkedChannelToAdd.value.length == tmpChannelList.value.data.length) {
        checkedChannelToAdd.value = [];
    }
})

watch(checkedChannelToAdd,  (after, before) => {
    if(tmpChannelList.value.data.length > after.length){
        checkboxAllChannel.value = false
    }else if(tmpChannelList.value.data.length == after.length){
        checkboxAllChannel.value = true
    }
})

const embedUrl = router.resolve({
    name: 'LiveEmbed',
    params: { lhash: route.params.hash}
});
const shareUrl = router.resolve({
    name: 'LiveShare',
    params: { lhash: route.params.hash}
});
const streamStatus = ref(0)

const getLiveStreamContent = () => {
    streamStatus.value = 1;
    store
        .dispatch('liveStreamEdit', route.params.hash)
        .then((res) => {
            if(res.data) {
                let data = res.data;

                model.value.id = data.id
                model.value.streamKey = data.stream_key
                model.value.title = data.title
                model.value.channel = JSON.parse(data.channels)
                model.value.bsignal = data.broadcast_signal == 0 ? false : true,
                model.value.liveStatus = data.live_status
                model.value.latestStreams = res.latestStreams

                share.value.url = `https://${window.location.host+shareUrl.href}`;
                share.value.embedCode = `<iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`;
                share.value.title = `Watch "${model.value.title}" Live on `;

                videoOptions.value.sources[0].src = `${import.meta.env.VITE_STREAM_URI}/hls/${data.stream_key}.m3u8`;
                checkStreamUri();
            }
        })
        .catch((err) => {
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

const updateStream = async () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    await store
    .dispatch('liveStreamUpdate', model['_rawValue'])
    .then((res) => {
        internalInstance.appContext.config.globalProperties.$Progress.finish();
        if(res.data) {
            let data = res.data;

            model.value.streamKey = data.stream_key
            model.value.title = data.title
            model.value.channel = JSON.parse(data.channels)
            model.value.bsignal = data.broadcast_signal == 0 ? false : true,
            model.value.liveStatus = data.live_status
        }
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();

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

let timeoutStream;
let saveLiveVideo = ref(0) // 0: default, 1: ready to save, 2: save is ongoing, 3: saved
let saveLiveVideo2 = ref(0)
let playingLive = ref(0)
let playingLive2 = ref(0)

const checkStreamUri = () => {
    let lopper = () => {
        timeoutStream = setTimeout( async () => {
            await fetch(`${import.meta.env.VITE_STREAM_URI}/hls/${model['_rawValue'].streamKey}.m3u8`)
            .then(res => res)
            .then(data => {
                if(data.status) {
                    if(data.status == 404) {
                        streamStatus.value = 3;
                        model.value.liveStatus = 'idle'
                        lopper();
                    } else if(data.status == 200) {
                        streamStatus.value = 2;
                        model.value.liveStatus = 'live'
                        // check live status if is not there then download video after 10 sec
                        let _liveStatus = document.getElementsByClassName('vjs-seek-to-live-control')[0];
                        let _liveStatus2 = document.getElementsByClassName('vjs-live-control')[0];
                        
                        if(_liveStatus){
                            if(_liveStatus.getAttribute('title').includes('currently playing live')) {
                                playingLive.value = 1
                            }else if(_liveStatus.getAttribute('title').includes('currently behind live')) {
                                if(playingLive.value == 1) {
                                    saveLiveVideo.value = 1
                                } 
                            }
                        }

                        if(_liveStatus2) {
                            if (!_liveStatus2.classList.contains('vjs-hidden')) {
                                playingLive2.value = 1
                            }else if(_liveStatus2.classList.contains('vjs-hidden')) {
                                if( playingLive2.value == 1) {
                                    saveLiveVideo2.value = 1
                                }
                            }
                        }

                        if(saveLiveVideo.value == 1 && playingLive.value == 1) {
                            playingLive.value = 2; saveLiveVideo.value = 2;
                            // run save
                            setTimeout(() => {
                                storeLiveVideo();
                            }, 12000);
                        }
                        if(saveLiveVideo2.value == 1 && playingLive2.value == 1) {
                            playingLive2.value = 2; saveLiveVideo2.value = 2;
                            // run save
                            setTimeout(() => {
                                storeLiveVideo();
                            }, 12000);
                        }

                        lopper();
                    } else if(data.status == 500) {
                        streamStatus.value = 3;
                        model.value.liveStatus = 'idle'
                        lopper();
                    }
                }
                // console.log(`from fetch ${data.status}`)
            })
            .catch(err => {
                streamStatus.value = 3;
                lopper();
                console.log(`error ${err}`)
            })

        }, 12000)
    }
    lopper();
}

const storeLiveVideo = () => {
    saveLiveVideo.value = 2
    saveLiveVideo2.value = 2
    playingLive.value = 2
    playingLive2.value = 2

    store
        .dispatch('liveStreamVideo', {
            link: videoOptions.value.sources[0].src,
            lhash: route.params.hash,
            channel: model.value.channel,
        })
        .then((res) => {
            if (res.latestStreams.length > 0){
                saveLiveVideo.value = 3
                saveLiveVideo2.value = 3
                playingLive.value = 0 
                playingLive2.value = 0     
            }
        })
        .catch((err) => {

        })
}

const broadcastSignal = () => {
    updateStream();
}

const getChannelList = (ev) => {
    ev.preventDefault();
    isChannelSet.value = 1;

    store
        .dispatch('getChannelList')
        .then((res) => {
            if(res.data.length)
                isChannelSet.value = 2;
            else
                isChannelSet.value = 3;

            tmpChannelList.value.data = res.data;
            checkedChannelToAdd.value = [];
        })
        .catch((err) => {
            isChannelSet.value = 0;
            openChannelList.value = false;
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
    openChannelList.value = true;
}

const addChannel = () => {
    // validate checks
    if(!checkedChannelToAdd.value.length){
        return false;
    }

    isDisabled.value = true;

    for (let c of checkedChannelToAdd['_rawValue']) {
        for(let cid of tmpChannelList['_rawValue'].data) {
            if(c == cid.id) {
                model.value.channel.push(cid)
                tmpChannelModel.value.push(cid)
            }
        }
    }

    model.value.channel = model['_rawValue'].channel.filter((v,i,a)=>a.findIndex(v2=>(v2.id===v.id))===i); 
    tmpChannelModel.value = tmpChannelModel['_rawValue'].filter((v,i,a)=>a.findIndex(v2=>(v2.id===v.id))===i);
    openChannelList.value = false;
    isDisabled.value = false;
    updateStream();
}

const removeChannel = (id) => {
    let filtered = model['_rawValue'].channel.filter(data => data.id != id)
    let tmpfiltered = tmpChannelModel['_rawValue'].filter(data => data.id != id)

    model.value.channel = [];
    tmpChannelModel.value = [];

    for (let f of filtered) {
        model.value.channel.push(f)
    }
    for (let f of tmpfiltered) {
        tmpChannelModel.value.push(f)
    }
    updateStream();
}

// embed content  
const embedContent = () => {
    embedLink.value = `https://${window.location.host+embedUrl.href}`
    shareLink.value = `https://${window.location.host+shareUrl.href}`
    code.value = `<div style='position: relative; padding-bottom: ${embedFilters.value.ratio}; height: 0;'><iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&controls=1&title=1&share=1' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%;' frameborder='0' allow='autoplay' allowfullscreen></iframe></div>`

    share.value.url = `https://${window.location.host+shareUrl.href}`;
    share.value.embedCode = `<iframe src='https://${window.location.host+embedUrl.href}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`;
    share.value.title = `Watch "${model.value.title}" Live on `;
    openEmbedCode.value = true;
    embedVideoShow.value = 2;
}

const embedCode = (item) => {
    if(item.isPicked == 'responsive') {
        code.value = `<div style='position: relative; padding-bottom: ${item.ratio}; height: 0;'><iframe src='${embedLink.value}?autoplay=${item.isAutoPlay == true ? 1 : 0}&volume=${item.isVolume == true ? 1 : 0}&controls=${item.sControls == true ? 1 : 0}&title=${item.sContentTitle == true ? 1 : 0}&share=${item.sShare == true ? 1 : 0}' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%;' frameborder='0' allow='autoplay' allowfullscreen></iframe></div>`
    }else {
        code.value = `<iframe src='${embedLink.value}?autoplay=${item.isAutoPlay == true ? 1 : 0}&volume=${item.isVolume == true ? 1 : 0}&controls=${item.sControls == true ? 1 : 0}&title=${item.sContentTitle == true ? 1 : 0}&share=${item.sShare == true ? 1 : 0}' width='${item.pixelWid}' height='${item.pixelLen}' frameborder='0' allow='autoplay' allowfullscreen></iframe>`
    }
}

// copy to clipboard
const copyData = (data, elmId, elmId2) => {
    let copyText = document.getElementById(elmId);
    let tooltip = document.getElementById(elmId2);

    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(data);
    tooltip.innerHTML = "Copied!";

    setTimeout(() => {
        tooltip.innerHTML = "Copy"
    }, 1500);
//   alert("Copied to clipboard!");
}

onMounted(() => {
    getLiveStreamContent();
})

onUnmounted(() => {
    clearTimeout(timeoutStream);
})
</script>

<style scoped>
.tooltip .tooltiptext {
  visibility: hidden;
  min-width: 40px;
  background-color: #000000;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 120%;
  left: 160%;
  margin-left: -68px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip-embed .tooltiptext {
  visibility: hidden;
  min-width: 40px;
  background-color: #000000;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 8px;
  position: absolute;
  z-index: 1;
  bottom: 120%;
  left: 80%;
  margin-left: -68px;
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

.tooltip-embed .tooltiptext::after {
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

.tooltip-embed:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>