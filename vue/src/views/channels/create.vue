<template>
  <div>
    <page-component title="Channels">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Create channel</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Get started in minutes.</p>
            </div>
            <div class="border-t border-gray-200">
                <div class="mt-6 px-10">
                    <ol class="relative border-l border-gray-200 dark:border-gray-700">
                        <li class="mb-10 ml-6">
                            <span class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path 
                                        fill-rule="evenodd" 
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <h3 class="flex items-center mb-1 text-md font-semibold text-gray-900 dark:text-white">
                                Choose the channel type
                            </h3>
                            <div class="mt-12">
                                <div class="justify-between items-center p-4 bg-white 
                                    rounded-lg border border-gray-200 shadow-sm 
                                    dark:bg-gray-700 dark:border-gray-600"
                                >
                                    <div class="sm:hidden">
                                        <label for="tabs" class="sr-only">Select channel playback type</label>
                                        <select id="tabs" 
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm 
                                            rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full 
                                            p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                            dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
                                            <option>Linear</option>
                                            <option>On demand</option>
                                        </select>
                                    </div>
                                    <ul 
                                        class="hidden text-md font-medium text-center text-gray-500 rounded-lg
                                        divide-x divide-gray-200 shadow sm:flex dark:divide-gray-700 dark:text-gray-400"
                                    >
                                        <li class="w-full">
                                            <a href="#" @click="toogleTypes($event, 'linear')"
                                                class="inline-block p-8 w-full rounded-l-lg focus:outline-none 
                                                dark:text-white" aria-current="page"
                                                :class="[
                                                    channelType.linear == 'active' 
                                                    ? 'active bg-gray-300 text-gray-900 dark:bg-gray-700'
                                                    : 'bg-white hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700'
                                                ]"
                                            >Linear</a>
                                        </li>
                                        <li class="w-full">
                                            <a href="#" @click="toogleTypes($event, 'demand')"
                                                class="inline-block p-8 w-full rounded-r-lg focus:outline-none "
                                                :class="[
                                                    channelType.onDemand == 'active' 
                                                    ? 'active  bg-gray-300 text-gray-900 dark:bg-gray-700'
                                                    : 'bg-white hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700'
                                                ]"
                                            >On demand</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li v-if="channelType.linear == 'active'" class="mb-10 ml-6">
                            <span class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            </span>
                            <h3 class="mb-1 text-md font-semibold text-gray-900 dark:text-white">
                                Do you want the channel content to repeat on a fixed schedule or in a loop?
                            </h3>
                            <div class="mt-12">
                                <div class="justify-between items-center p-4 bg-white 
                                    rounded-lg border border-gray-200 shadow-sm  
                                    dark:bg-gray-700 dark:border-gray-600"
                                >
                                    <div class="sm:hidden">
                                        <label for="tabs" class="sr-only">Select channel playback type</label>
                                        <select id="tabs" 
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm 
                                            rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full 
                                            p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                            dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
                                            <option>Scheduled</option>
                                            <option>Looped</option>
                                        </select>
                                    </div>
                                    <ul 
                                        class="hidden text-md font-medium text-center text-gray-500 rounded-lg
                                        divide-x divide-gray-200 shadow sm:flex dark:divide-gray-700 dark:text-gray-400"
                                    >
                                        <li class="w-full">
                                            <a href="#" @click="toogleTypes($event, 'scheduled')"
                                                class="inline-block p-8 w-full rounded-l-lg focus:outline-none "
                                                :class="[
                                                    channelType.scheduled == 'active' 
                                                    ? 'active  bg-gray-300 text-gray-900 dark:bg-gray-700'
                                                    : 'bg-white hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700'
                                                ]"
                                            >
                                                Scheduled
                                            </a>
                                        </li>
                                        <li class="w-full">
                                            <a href="#" @click="toogleTypes($event, 'looped')"
                                                class="inline-block p-8 w-full rounded-r-lg focus:outline-none "
                                                :class="[
                                                    channelType.looped == 'active' 
                                                    ? 'active  bg-gray-300 text-gray-900 dark:bg-gray-700'
                                                    : 'bg-white hover:text-gray-700 hover:bg-gray-50 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700'
                                                ]"
                                            >
                                                Looped
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ol>
                    <div class="mb-6">
                        <button type="button"
                            @click="setUpChannel"
                            class="
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
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </page-component>
  </div>
</template>

<script setup>
import PageComponent from '../../components/PageComponent.vue'
import { PaperClipIcon } from '@heroicons/vue/solid'
import { useRouter } from 'vue-router'
import { ref } from 'vue'

const router = useRouter();
const channelType = ref({
    linear: 'active',
    onDemand: '',
    scheduled: 'active',
    looped: ''
})

const toogleTypes = (ev, type) => {
    ev.preventDefault();
    if(type == 'demand') {
        channelType.value.onDemand = 'active'
        channelType.value.linear = ''
    }else if(type == 'linear') {
        channelType.value.onDemand = ''
        channelType.value.linear = 'active'
    }else if(type == 'scheduled') {
        channelType.value.looped = ''
        channelType.value.scheduled = 'active'
    }else {
        channelType.value.looped = 'active'
        channelType.value.scheduled = ''
    }
}

const setUpChannel = () => {
    let linear = channelType['_rawValue'].linear
    let schedule = channelType['_rawValue'].scheduled
    let looped = channelType['_rawValue'].looped

    if(linear == 'active') {
        if(schedule == 'active')
            router.push({name: 'Scheduled'})
        if(looped == 'active')
            router.push({name: 'Looped'})
    }else {
        router.push({name: 'Ondemand'})
    }
}

</script>