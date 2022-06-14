<template>
  <div>
    <page-component title="Channels">
        <notification />
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Create channel</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Get started in minutes.</p>
            </div>
            <div class="border-t border-gray-200">
                <div class="py-6 px-6">
                    <h3 class="flex items-center mb-1 text-md font-semibold text-gray-900 dark:text-white">
                        {{title}}
                    </h3>
                    <div class="mt-8">
                        <form @submit.prevent="postChannel">
                            <div class="relative z-0 w-full mb-6 group">
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

                                <div v-if="title.includes('Scheduled')">
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

                                <div v-if="title.includes('Looped')">
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
                                            <div class="ml-2">
                                                With current timezone Africa/Lagos
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
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
                                                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
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
                                                        <color-picker v-model:pureColor="pureColor" v-model:gradientColor="gradientColor"/>
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
                                                                type="url"
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
                                                    <div class="relative z-0 mt-3">
                                                        <input
                                                            type="url"
                                                            id="ads_tag_url"
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
                                                <video-player 
                                                    :options="videoOptions" 
                                                    :playlistOptions="playlist" 
                                                    :shareOptions="share"
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
                </div>
            </div>
        </div>
    </page-component>
  </div>
</template>

<script setup>
import PageComponent from './PageComponent.vue';
import VideoPlayer from './VideoPlayer.vue';
import store from '../store';
import Notification from './Notification.vue';
import { ref, watch, getCurrentInstance } from 'vue';
import { ColorInputWithoutInstance } from "tinycolor2";
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const internalInstance = getCurrentInstance();
const pureColor = ref<ColorInputWithoutInstance>("red");
const gradientColor = ref("linear-gradient(0deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 1) 100%)");

const props = defineProps({
    title: String,
});

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
    channelType: props.title,
    timezone: null
})

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

let isDisabled = ref(false);

watch(channelModel, (after, before) => {
  channelModel.value.domains = channelModel.value.privacy == 'anywhere' ? [] : channelModel.value.domains
}, {deep: true})

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
  playbackRates: [0.5, 1, 1.5, 2],
  sources: [
    {
      src: 'https://muxed.s3.amazonaws.com/ink.mp4',
      type: 'video/mp4',
    }
  ],
}

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
    },
    {
        name: 'Ocean',
        sources: [{
            src: 'https://muxed.s3.amazonaws.com/ink.mp4',
            type: 'video/mp4'
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

const postChannel = async () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;
    let colorPicker = document.querySelector('.current-color').style.background;

    await store
        .dispatch('storeChannel', {
            title: channelModel.value.name,
            schedule: channelModel.value.schedule,
            starttime: `${channelModel.value.looptimeH}:${channelModel.value.looptimeM}`,
            timezone: channelModel.value.timezone,
            logo: channelModel.value.logo == true ? channelModel.value.image : null,
            logolink: channelModel.value.logoLink,
            logoposition: channelModel.value.logoPosition,
            color: colorPicker,
            twitter: channelModel.value.twitter,
            privacy: channelModel.value.privacy,
            privacydomain: channelModel.value.privacy == 'anywhere' ? null : channelModel.value.domains.toString(),
            adtagurl: channelModel.value.monetization,  
            channeltype: channelModel.value.channelType
        })
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            isDisabled.value = false;
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch("setSuccessNotification", res.status);
            router.push({name: 'Channels'})
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

</script>