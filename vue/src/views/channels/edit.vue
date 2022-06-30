<template>
    <div>
        <channel-header>
            <notification />
            <template v-slot:header>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit channel</h3>
            </template>
            <div class="py-6 px-10">
                <form @submit.prevent="updateChannel">
                    <div class="">
                        <h3 class="flex items-center mb-1 text-md font-semibold text-gray-900 dark:text-white">
                            Type:
                        </h3>
                        <div class="flex">
                            <select
                                v-model="channelModel.channelType"
                                id="select_schedule"
                                class="block py-2 xl:w-1/5 sm:w-1/4
                                text-sm text-gray-500 bg-transparent
                                border-0 border-b-2 border-gray-300
                                appearance-none dark:text-gray-400 
                                dark:border-gray-600 focus:outline-none 
                                focus:ring-0 focus:border-gray-200 peer"
                            >
                                <option value="Playlist (On demand)">Playlist (On demand)</option>
                                <option value="Looped (Linear)" >Looped (Linear)</option>
                                <option value="Scheduled (Linear)" >Scheduled (Linear)</option>
                            </select>
                            <div class="xl:w-4/5 ml-6 text-sm">
                                <p v-if="channelModel.cType != channelModel.channelType">
                                    You have changed the channel type and some settings may be lost. <br>
                                    The content of the channel will be maintained.
                                </p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="relative z-0 w-full mb-6 mt-6 group">
                        <input 
                            type="text" 
                            name="channel_name" 
                            class="block py-2.5 px-0 w-full text-sm 
                            text-gray-900 bg-transparent border-0 
                            border-b-2 border-gray-300 appearance-none 
                            dark:text-white dark:border-gray-600 
                            dark:focus:border-blue-500 focus:outline-none 
                            focus:ring-0 focus:border-blue-600 peer" 
                            placeholder=" " required=""
                            v-model="channelModel.name"
                        >
                        <label 
                            for="channel_name" 
                            class="peer-focus:font-medium absolute 
                            text-sm text-gray-500 dark:text-gray-400 
                            duration-300 transform -translate-y-6 scale-75 
                            top-3 -z-10 origin-[0] peer-focus:left-0 
                            peer-focus:text-blue-600 peer-focus:dark:text-blue-500 
                            peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                            peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Channel Name
                        </label>
                        <div v-if="channelModel.channelType.includes('Scheduled')">
                            <h3 class="flex items-center mb-1 mt-4 text-md font-semibold text-gray-900 dark:text-white">
                                Scheduler duration:
                            </h3>
                            <div 
                                class="justify-between items-center p-4 bg-white 
                                rounded-lg border border-gray-200 shadow-sm 
                                dark:bg-gray-700 dark:border-gray-600 "
                            >
                                <div class="grid xl:grid-cols-12 xl:gap-4">
                                    <div class="xl:col-span-1 md:col-span-3 sm:col-span-3">
                                        <label for="select_schedule" class="sr-only">Select schedule</label>
                                        <select
                                            v-model="channelModel.schedule"
                                            id="select_schedule"
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
                                                peer"
                                        >
                                            <option selected value="weekly">Weekly</option>
                                            <option value="daily">Daily</option>
                                        </select>
                                    </div>
                                    <div class="col-span-8">
                                        <p v-if="channelModel.schedule == 'weekly'">
                                            You will schedule a whole week 24/7 and content will be repeated weekly.
                                        </p>
                                        <p v-else>
                                            You will schedule one day (24 hours) and content will be repeated daily.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="channelModel.channelType.includes('Looped')">
                            <h3 class="flex items-center mb-1 mt-4 text-md font-semibold text-gray-900 dark:text-white">
                                Start time:
                            </h3>
                            <div 
                                class="justify-between items-center p-4 bg-white 
                                rounded-lg border border-gray-200 shadow-sm 
                                dark:bg-gray-700 dark:border-gray-600 "
                            >
                                <div class="flex">
                                    <div class="">
                                        <select
                                            v-model="channelModel.looptimeH"
                                            id="select_schedule"
                                            class="
                                                block
                                                py-2
                                                w-full
                                                text-sm text-gray-500
                                                bg-transparent
                                                border-0 border-b-2 border-gray-300
                                                appearance-none
                                                dark:text-gray-400 dark:border-gray-600
                                                focus:outline-none focus:ring-0 focus:border-gray-200
                                                peer"
                                        >

                                            <option v-for="hr in lhours" :key="hr" :value="hr" >{{hr}}</option>
                                        </select>
                                    </div>
                                    <div >:</div>
                                    <div class="">
                                        <select
                                            v-model="channelModel.looptimeM"
                                            id="select_schedule"
                                            class="
                                                block
                                                py-2
                                                w-full
                                                text-sm text-gray-500
                                                bg-transparent
                                                border-0 border-b-2 border-gray-300
                                                appearance-none
                                                dark:text-gray-400 dark:border-gray-600
                                                focus:outline-none focus:ring-0 focus:border-gray-200
                                                peer"
                                        >
                                            <option v-for="min in lmins" :key="min" :value="min">{{min}}</option>
                                        </select>
                                    </div>
                                    <div class="ml-2 text-sm">
                                        <!-- With current timezone Africa/Lagos -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mt-6 mb-4">
                        <h3 class="flex items-center mb-1 text-md font-semibold text-gray-900 dark:text-white">
                            Player settings:
                        </h3>
                        <div 
                            class="justify-between items-center p-4 bg-white 
                            rounded-lg border border-gray-200 shadow-sm 
                            dark:bg-gray-700 dark:border-gray-600"
                        >
                            <div class="grid xl:grid-cols-12 xl:gap-3">
                                <div class="col-span-4">
                                    <h3 class="flex items-center mb-1 text-md font-semibold text-gray-900 dark:text-white">
                                        Player Customization
                                    </h3>
                                    <div class="grid grid-cols-3 gap-4 mt-5">
                                        <div class="">
                                            <label for="default-toggle" class="relative inline-flex items-center mb-4 cursor-pointer">
                                                <input type="checkbox" id="default-toggle" class="sr-only peer" v-model="channelModel.logo">
                                                <div 
                                                    class="w-11 h-6 bg-gray-200 rounded-full peer 
                                                    peer-focus:ring-blue-300 
                                                    dark:peer-focus:ring-blue-800 dark:bg-gray-700 
                                                    peer-checked:after:translate-x-full 
                                                    peer-checked:after:border-white 
                                                    after:content-[''] after:absolute after:top-0.5 
                                                    after:left-[2px] after:bg-white after:border-gray-300 
                                                    after:border after:rounded-full after:h-5 after:w-5 
                                                    after:transition-all dark:border-gray-600 
                                                    peer-checked:bg-blue-600"
                                                ></div>
                                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Logo</span>
                                            </label>
                                            <!-- channel logo -->
                                            <div>
                                                <div class="mt-1 flex items-center">
                                                    <img v-if="channelModel.imageUrl" 
                                                        :src="channelModel.imageUrl" 
                                                        class="w-64 h-44 object-cover"
                                                    />
                                                    <span v-else class="inline-block h-20 w-[4.5rem]  overflow-hidden bg-gray-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <button type="button" 
                                                    class="relative overflow-hidden bg-white py-2 px-3 border border-gray-300
                                                    shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 
                                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                >
                                                    <input 
                                                        type="file" 
                                                        class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                                                        :disabled="channelModel.logo == false ? true : false"
                                                        @change="onLogoChoose"
                                                    >
                                                    Change
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-span-2">
                                            <div class="relative z-0">
                                                <input 
                                                    type="text" 
                                                    id="logo_link" 
                                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 
                                                    bg-transparent border-0 border-b-2 border-gray-300 
                                                    appearance-none dark:text-white dark:border-gray-600 
                                                    dark:focus:border-blue-500 focus:outline-none 
                                                    focus:ring-0 focus:border-blue-600 peer" 
                                                    placeholder=" " 
                                                    :readonly="channelModel.logo == false ? true : false"
                                                    v-model="channelModel.logoLink"
                                                />
                                                <label 
                                                    for="logo_link" 
                                                    class="absolute text-sm text-gray-500 dark:text-gray-400 
                                                    duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                                                    origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                                                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                                                    peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                                    peer-focus:-translate-y-6" 
                                                >Logo link</label>
                                            </div>
                                            <div class="mt-3">
                                                <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Logo position</span>
                                                <div class="flex mt-2">
                                                    <div class="flex items-center mr-4">
                                                        <input 
                                                            id="inline-radio" 
                                                            type="radio" 
                                                            value="left" 
                                                            name="inline-radio-group" 
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 
                                                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                                            dark:border-gray-600"
                                                            :disabled="channelModel.logo == false ? true : false"
                                                            v-model="channelModel.logoPosition"
                                                        >
                                                        <label 
                                                            for="inline-radio" 
                                                            class="ml-2 text-sm text-gray-900 dark:text-gray-300"
                                                        >Left</label>
                                                    </div>
                                                    <div class="flex items-center mr-4">
                                                        <input 
                                                            id="inline-2-radio" 
                                                            type="radio" 
                                                            value="right" 
                                                            name="inline-radio-group" 
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 
                                                            focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                                            focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            :disabled="channelModel.logo == false ? true : false"
                                                            v-model="channelModel.logoPosition"
                                                        >
                                                        <label 
                                                            for="inline-2-radio" 
                                                            class="ml-2 text-sm text-gray-900 dark:text-gray-300"
                                                        >Right</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- main color / twitter -->
                                    <div class="grid grid-cols-3 gap-2 mt-5">
                                        <div >
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Main color</span>
                                            <div class="flex">
                                                <span
                                                    class="inline-flex items-center px-3
                                                    text-sm text-gray-900 bg-gray-200 
                                                    border border-gray-300 
                                                    dark:bg-gray-600 dark:text-gray-400 
                                                    dark:border-gray-600"
                                                    :style="{background: channelModel.color}"
                                                ></span>
                                                <input type="text" id="bg-color" 
                                                    class="rounded-none bg-gray-50
                                                    text-gray-900 block flex-1 min-w-0 
                                                    text-sm border-gray-300 p-2 border-0"
                                                    v-model="channelModel.color"
                                                    @click="bgPicker.show = true"
                                                    @blur="bgPicker.show = false"
                                                >
                                            </div>
                                            <ColorPicker
                                                class="z-50 absolute "
                                                theme="light"
                                                :color="channelModel.color"
                                                :sucker-hide="true"
                                                :sucker-canvas="bgPicker.suckerCanvas"
                                                :sucker-area="bgPicker.suckerArea"
                                                @changeColor="changeColor"
                                                @openSucker="openSucker"
                                                v-show="bgPicker.show == true"
                                            />
                                        </div>
                                        <div class="col-span-2">
                                            <div class="relative z-0">
                                                <div class="flex absolute inset-y-0 left-0 
                                                    items-center pl-3 pointer-events-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                                        class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                                    </svg>
                                                </div>
                                                <input
                                                    type="text"
                                                    id="twitter_id"
                                                    class="block pl-10 py-2 px-0 w-full
                                                    text-sm text-gray-900 bg-transparent
                                                    border-0 border-b-2 border-gray-300
                                                    appearance-none dark:text-white
                                                    dark:border-gray-600 dark:focus:border-blue-500
                                                    focus:outline-none focus:ring-0 focus:border-blue-600
                                                    peer" placeholder=" "
                                                    v-model="channelModel.twitter"
                                                />
                                                <label
                                                    for="twitter_id"
                                                    class="absolute pl-10 text-sm text-gray-500
                                                    dark:text-gray-400 duration-300 transform
                                                    -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                                    peer-focus:left-0 peer-focus:text-blue-600
                                                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                                    peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                                    peer-focus:-translate-y-6"
                                                >Twitter</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Privacy settings -->
                                    <div>
                                        <h3 class="flex items-center mb-1 mt-6 text-md font-semibold text-gray-900 dark:text-white">
                                            Privacy settings
                                        </h3>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Where can this channel be embedded?
                                        </span>
                                        <div class="flex items-center mb-4 mt-2">
                                            <input id="default-radio-1" type="radio" value="anywhere" name="default-radio" 
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 
                                                focus:ring-blue-500 dark:focus:ring-blue-600 
                                                dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                                dark:border-gray-600"
                                                v-model="channelModel.privacy"
                                            >
                                            <label for="default-radio-1" class="ml-4 text-sm text-gray-900 dark:text-gray-300">Anywhere</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="default-radio-2" type="radio" value="domain" name="default-radio" 
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 
                                                focus:ring-blue-500 dark:focus:ring-blue-600 
                                                dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                                dark:border-gray-600"
                                                v-model="channelModel.privacy"
                                            >
                                            <label for="default-radio-2" class="ml-4 text-sm text-gray-900 dark:text-gray-300">Only on domains I choose</label>
                                        </div>
                                        <div v-if="channelModel.privacy == 'domain'" class="grid xl:grid-cols-12 mt-3">
                                            <div class="relative z-0 col-span-9">
                                                <input
                                                    type="url"
                                                    id="domain"
                                                    class="block py-2 px-0 w-full
                                                    text-sm text-gray-900 bg-transparent
                                                    border-0 border-b-2 border-gray-300
                                                    appearance-none dark:text-white
                                                    dark:border-gray-600 dark:focus:border-blue-500
                                                    focus:outline-none focus:ring-0 focus:border-blue-600
                                                    peer" placeholder=" "
                                                />
                                                <label
                                                    for="domain"
                                                    class="absolute text-sm text-gray-500
                                                    dark:text-gray-400 duration-300 transform
                                                    -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                                    peer-focus:left-0 peer-focus:text-blue-600
                                                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                                    peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                                    peer-focus:-translate-y-6"
                                                >example.com</label>
                                            </div>
                                            <div class="col-span-3">
                                                <button
                                                    @click="passDomain"
                                                    type="button"
                                                    class=" justify-center py-2 px-3
                                                        border border-transparent text-sm font-medium
                                                        text-white bg-indigo-600 hover:bg-indigo-700
                                                        focus:outline-none"
                                                    >Add
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="tags" id="domains" v-model="channelModel.domains">
                                        <div v-if="channelModel.domains.length && channelModel.privacy == 'domain'" class="mt-2">
                                            <div class="grid xl:grid-col-2 xl:gap-1">
                                                <div v-for="domain in channelModel.domains" :key="domain">
                                                    <div class="flex">
                                                        <span class="flex bg-blue-100 text-blue-800 text-sm font-medium 
                                                        mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                        {{domain}} &nbsp;
                                                        <span @click="removeDomain(domain)"
                                                            class="w-4 h-4 flex items-center justify-center rounded-full 
                                                            transition-color cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Ads Monetization -->
                                    <div>
                                        <h3 class="flex items-center mb-1 mt-6 text-md font-semibold text-gray-900 dark:text-white">
                                            Ads Monetization
                                        </h3>
                                        <div class="relative z-0 mt-3 mb-4">
                                            <input
                                                type="url"
                                                id="ads_tag_url"
                                                v-model="channelModel.monetization"
                                                class="block py-2 px-0 w-full
                                                text-sm text-gray-900 bg-transparent
                                                border-0 border-b-2 border-gray-300
                                                appearance-none dark:text-white
                                                dark:border-gray-600 dark:focus:border-blue-500
                                                focus:outline-none focus:ring-0 focus:border-blue-600
                                                peer" placeholder=" "
                                            />
                                            <label
                                                for="ads_tag_url"
                                                class="absolute text-sm text-gray-500
                                                dark:text-gray-400 duration-300 transform
                                                -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                                peer-focus:left-0 peer-focus:text-blue-600
                                                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                                peer-focus:-translate-y-6"
                                            >Ad tag URL</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-8">
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
                                            :logoOptions="logoOptions"
                                            :playerColor="playerColor"
                                            :adsTag="channelModel.monetization"
                                            :loopPlaylist="loopPlaylist"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" 
                        class="text-white bg-blue-700 hover:bg-blue-800 
                        focus:outline-none focus:ring-blue-300 
                        font-medium text-sm w-full sm:w-auto px-5 py-2.5 
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                        dark:focus:ring-blue-800" :disabled="isDisabled"
                    >Accept</button>
                    <router-link :to="{name: 'Channels'}"
                        class="ml-4 text-white bg-gray-400 hover:bg-gray-800 
                        focus:outline-none focus:ring-gray-300 
                        font-medium text-sm w-full sm:w-auto px-5 py-2.5 
                        text-center dark:bg-gray-600 dark:hover:bg-gray-700 
                        dark:focus:ring-gray-800"
                    >Cancel</router-link>
                </form>
            </div>
        </channel-header>
    </div>  
</template>

<script setup>
import ChannelHeader from '../../components/ChannelHeader.vue';
import Notification from '../../components/Notification.vue';
import VideoPlayer from '../../components/VideoPlayerChannel.vue';
import store from '../../store';
import { ref, onMounted, getCurrentInstance } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { ColorPicker } from 'vue-color-kit';
import 'vue-color-kit/dist/vue-color-kit.css';

const router = useRouter();
const route = useRoute();
const internalInstance = getCurrentInstance();
const channelModel = ref({
    name: 'Untitled Channel',
    logo: false,
    logoLink: '',
    logoPosition: 'right',
    image: null,
    twitter: '',
    privacy: 'anywhere',
    monetization: '',
    imageUrl: null, // for upload display
    domains: [],
    schedule: 'weekly',
    looptimeH: '00',
    looptimeM: '00',
    channelType: '',
    timezone: null,
    color: '',
    cType: '', // checks purpose
    id: null,
})

let bgPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});

const changeColor = (color) => {
  const { r, g, b, a } = color.rgba
  bgPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
  bgPicker.value.colorHex = color.hex
  channelModel.value.color = color.hex
}
const openSucker = (isOpen) => {
  if (isOpen) {
    // ... canvas be created
    // bgPicker.value.suckerCanvas = canvas
    // bgPicker.value.suckerArea = [x1, y1, x2, y2]
  } else {
    // bgPicker.value.suckerCanvas && bgPicker.value.suckerCanvas.remove
  }
}

let logoOptions = ref({
    type: 'img',
    image: channelModel.value.logo == null ? channelModel.value.logoLink : channelModel.value.logo,
    opacity: 0.9,
    position: channelModel.value.logoPosition == 'left' ? 'top-left' : null,
    show: true
});
let playerColor = ref('#6366F1');
let loopPlaylist = ref(false);

const playlist = ref([]);
const ChannelPlaylistCheck = ref(0)
const lhours = ref([]);
const lmins = ref([]);

for (let h=0; h<24; h++){
    if(h<10){
        h = '0'+h
        lhours.value.push(h)
    }else{
        lhours.value.push(h.toString())
    }
}

let m = 0;
while (m <= 45){
    if (m < 10)
        lmins.value.push('0'+m)
    else
        lmins.value.push(m.toString())
    m = m + 15
}

const editChannel = () => {
    store
        .dispatch('editChannel', route.params.hash)
        .then((res) => {
            dataPlacement(res.data)
        })
        .catch((err) => {
            if (err.response){
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty('message')){
                        store.dispatch("setErrorNotification", err.response.data.message);
                    }else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        });
}

const updateChannel = async () => {
    await store
        .dispatch('updateChannel', {
            id: channelModel.value.id,
            title: channelModel.value.name,
            schedule: channelModel.value.schedule,
            starttime: channelModel.value.looptimeH+':'+channelModel.value.looptimeM,
            timezone: channelModel.value.timezone,
            logoEnable: channelModel.value.logo,
            logo: channelModel.value.image,
            logolink: channelModel.value.logoLink,
            logoposition: channelModel.value.logoPosition,
            color: channelModel.value.color,
            twitter: channelModel.value.twitter,
            privacy: channelModel.value.privacy,
            privacydomain: channelModel.value.privacy == 'anywhere' ? null : channelModel.value.domains.toString(),
            adtagurl: channelModel.value.monetization,
            channeltype: channelModel.value.channelType
        })
        .then((res) => {
            router.push({name: 'Channels'})
        })
        .catch((err) => {
            if (err.response.data) {
                if (err.response.data.hasOwnProperty('message')){
                store.dispatch("setErrorNotification", err.response.data.message);
                }else {
                store.dispatch("setErrorNotification", err.response.data.error);
                }
            }
        });
}

const passDomain = (ev) => {
    ev.preventDefault();

    let domain = document.getElementById('domain');
    if(domain.value !='')
        channelModel.value.domains.push(domain.value);

    domain.value = '';
}

const removeDomain = (domain) => {
    let filtered = channelModel['_rawValue'].domains.filter(data => data != domain)

    channelModel.value.domains = [];

    for (let f of filtered) {
        channelModel.value.domains.push(f)
    }
}

const onLogoChoose = (ev) => {
    const file = ev.target.files[0];
    const reader = new FileReader();

    reader.onload = () => {
        channelModel.value.image = reader.result;
        channelModel.value.imageUrl = reader.result;
    }
    reader.readAsDataURL(file)
}

const videoOptions = {
  autoplay: false,
  controls: true,
  muted: false,
  loop: false,
//   playbackRates: [0.5, 1, 1.5, 2],
//   sources: [
//     {
//       src: 'https://muxed.s3.amazonaws.com/ink.mp4',
//       type: 'video/mp4',
//     }
//   ],
}

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

const dataPlacement = async (data) => {
    channelModel.value.name = data.title
    channelModel.value.logo = data.logo_enable == 1 ? true : false
    channelModel.value.logoLink = data.logo_link
    channelModel.value.logoPosition = data.logo_position
    channelModel.value.image = data.logo
    channelModel.value.imageUrl = data.logo
    channelModel.value.twitter = data.twitter
    channelModel.value.privacy = data.privacy
    channelModel.value.monetization = data.ad_tag_url
    channelModel.value.domains = data.privacy_domain != null ? data.privacy_domain.split(',') : []
    channelModel.value.schedule = data.schedule_duration
    channelModel.value.looptimeH = data.start_time.split(':')[0]
    channelModel.value.looptimeM = data.start_time.split(':')[1]
    channelModel.value.channelType = data.channel_type
    channelModel.value.timezone = data.timezone
    channelModel.value.color = data.color
    channelModel.value.cType = data.channel_type
    channelModel.value.id = data.id

    playlist.value = [];
    ChannelPlaylistCheck.value = 1;

    await store
        .dispatch('getPlaylist', data.channel_hash)
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
            }
            ChannelPlaylistCheck.value = 2;
            let twitter = data.twitter != null ? `via @${data.twitter}` : '';
            share.value.title = `Watch "${res.data[0].channel_title}" ${twitter} on `;
            const shareUrl = router.resolve({
            name: 'ShareChannel',
                params: {str: route.params.hash}
            });
            
            share.value.url = `https://${window.location.host+shareUrl.href}` // external sharing
            share.value.embedCode = `<iframe src='https://${window.location.host}/embed/channel/${route.params.hash}?autoplay=0&volume=1&random=0&controls=1&title=1&share=1' width='640' height='360' frameborder='0' allow='autoplay' allowfullscreen></iframe>`
            
            logoOptions.value.image = data.logo == null ? data.logo_link : data.logo
            logoOptions.value.position = data.logo_position == 'left' ? 'top-left' : null
            logoOptions.value.show = data.logo_enable == 1 ? true : false

            playerColor.value = data.color;
            if(data.channel_type == 'Looped (Linear)')
                loopPlaylist.value = true;
            
        });
}

onMounted(() => {
    editChannel()
})

</script>

<style>

</style>