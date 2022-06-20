<template>
  <div>
    <page-component-vue title="Analytics">
      <notification-vue />
      <h4 class="text-xl font-medium text-gray-900 dark:text-white">Total plays</h4>
      <div class="mt-6 grid xl:grid-cols-12 xl:gap-1">
        <div class="col-span-3">
          <div class="block text-center p-6 max-w-sm bg-white 
            border border-gray-200 shadow-md hover:bg-gray-100 
            dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
          >
            <p class="font-normal text-gray-700 dark:text-gray-400">Today</p>
            <h5 class="mb-3 mt-3 text-5xl tracking-tight text-gray-900 dark:text-white">{{model.today}}</h5>
          </div>
        </div>
        <div class="col-span-3">
          <div class="block text-center p-6 max-w-sm bg-white 
            border border-gray-200 shadow-md hover:bg-gray-100 
            dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
          >
            <p class="font-normal text-gray-700 dark:text-gray-400">Last 7 days</p>
            <h5 class="mb-3 mt-3 text-5xl tracking-tight text-gray-900 dark:text-white">{{model.sevendays}}</h5>
          </div>
        </div>
        <div class="col-span-3">
          <div class="block text-center p-6 max-w-sm bg-white 
            border border-gray-200 shadow-md hover:bg-gray-100 
            dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
          >
            <p class="font-normal text-gray-700 dark:text-gray-400">Last 30 days</p>
            <h5 class="mb-3 mt-3 text-5xl tracking-tight text-gray-900 dark:text-white">{{model.thirtydays}}</h5>
          </div>
        </div>
        <div class="col-span-3">
           <div class="block text-center p-6 max-w-sm bg-white 
            border border-gray-200 shadow-md hover:bg-gray-100 
            dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
          >
            <p class="font-normal text-gray-700 dark:text-gray-400">Total</p>
            <h5 class="mb-3 mt-3 text-5xl tracking-tight text-gray-900 dark:text-white">{{model.total}}</h5>
          </div>
        </div>
      </div>
      <h4 class="text-xl mt-10 font-medium text-gray-900 dark:text-white">Channel  plays</h4>
      <div class="grid xl:grid-cols-12 xl:gap-2 mt-6">
        <div v-if="queryParams.chash" class="col-span-3">
          <Listbox as="div" v-model="queryParams.chash">
            <div class="mt-1 relative">
              <ListboxButton 
                class="relative w-full bg-white border border-gray-300 
                rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default 
                focus:outline-none focus:ring-1 focus:ring-indigo-500 
                focus:border-indigo-500 sm:text-sm"
              >
                <span class="flex items-center">
                  <!-- <img :src="selected.avatar" alt="" class="flex-shrink-0 h-6 w-6 rounded-full" /> -->
                  <span class="ml-3 block truncate">{{ queryParams.chash.title }}</span>
                </span>
                <span :class="[active ? 'text-white' : 'text-black-100', 'absolute inset-y-0 right-0 flex items-center pr-10']">
                  <svg xmlns="http://www.w3.org/2000/svg" 
                    class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" 
                    />
                  </svg>
                  {{ queryParams.chash.total_views }}
                </span>
                <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                  <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
              </ListboxButton>

              <transition 
                leave-active-class="transition ease-in duration-100" 
                leave-from-class="opacity-100" 
                leave-to-class="opacity-0"
              >
                <ListboxOptions 
                  class="absolute z-10 mt-1 w-full bg-white shadow-lg 
                  max-h-56 rounded-md py-1 text-base ring-1 ring-black 
                  ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                >
                  <ListboxOption as="template" 
                    v-for="channel in channels.data" 
                    :key="channel.id" 
                    :value="channel"
                    v-slot="{ active, selected }"
                  >
                    <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                      <div class="flex items-center">
                        <!-- <img :src="person.avatar" alt="" class="flex-shrink-0 h-6 w-6 rounded-full" /> -->
                        <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                          {{ channel.title }}
                        </span>
                      </div>

                      <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                        <CheckIcon class="h-5 w-5" aria-hidden="true" />
                      </span>
                    </li>
                  </ListboxOption>
                </ListboxOptions>
              </transition>
            </div>
          </Listbox>
        </div>
        <div v-if="queryParams.chash" class="col-span-3">
          <Listbox as="div" v-model="queryParams.period">
            <!-- <ListboxLabel class="block text-sm font-medium text-gray-700  mt-6"> Assigned to </ListboxLabel> -->
            <div class="mt-1 relative">
              <ListboxButton 
                class="relative w-full bg-white border border-gray-300 
                rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default 
                focus:outline-none focus:ring-1 focus:ring-indigo-500 
                focus:border-indigo-500 sm:text-sm">
                <span class="flex items-center">
                  <!-- <img :src="selected.avatar" alt="" class="flex-shrink-0 h-6 w-6 rounded-full" /> -->
                  <span class="ml-3 block truncate">{{ queryParams.period.name }}</span>
                </span>
                <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                  <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
              </ListboxButton>

              <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <ListboxOptions 
                  class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 
                  rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 
                  overflow-auto focus:outline-none sm:text-sm">
                  <ListboxOption as="template" 
                    v-for="period in model.period" 
                    :key="period.val" 
                    :value="period" 
                    v-slot="{ active, selected }">
                    <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                      <div class="flex items-center">
                        <!-- <img :src="person.avatar" alt="" class="flex-shrink-0 h-6 w-6 rounded-full" /> -->
                        <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                          {{ period.name }}
                        </span>
                      </div>

                      <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                        <CheckIcon class="h-5 w-5" aria-hidden="true" />
                      </span>
                    </li>
                  </ListboxOption>
                </ListboxOptions>
              </transition>
            </div>
          </Listbox>
        </div>
      </div>
      <!-- display chart -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-10">
        <div class="px-4 py-5 sm:px-6">
          <div v-if="queryParams.chash" class="col-span-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{queryParams.chash.title}}</h3>
          </div>
        </div>
        <div class="border-t border-gray-200">
          <div v-if="setChartDataCheck == 1" class="flex justify-center py-20">
            <!-- spinner state -->
            <svg role="status" 
              class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" 
              viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
          </div>
          <div v-if="setChartDataCheck == 2" class="py-6 px-10">
            <div class="text-center">
              <span class="text-4xl font-medium">{{model.channelTotal}}</span> 
              <span v-if="queryParams.period" class="pl-2 text-gray-500">Plays in {{queryParams.period.name}}</span>
            </div>
            <div class="mt-10">
              <tmc-chartjs-vue :options="model.channelChart" />
            </div>
          </div>
        </div>
      </div>
    </page-component-vue>
  </div>
</template>

<script setup>
import PageComponentVue from '../../components/PageComponent.vue';
import NotificationVue from '../../components/Notification.vue';
import tmcChartjsVue from '../../components/tmcChartjs.vue';
import store from '../../store';
import { ref } from '@vue/reactivity';
import { computed, onMounted, watch } from '@vue/runtime-core';
import { getCurrentInstance } from 'vue';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'
import { PaperClipIcon } from '@heroicons/vue/solid';

const internalInstance = getCurrentInstance();
const channels = computed(() => store.state.channels);
const model = ref({
  today: 0,
  sevendays: 0,
  thirtydays: 0,
  total: 0,
  period: [
    {val: 7, name: 'Last 7 days'}, 
    {val: 30, name: 'Last 30 days'},
    {val: 365, name: 'Last 365 days'}
  ],
  channelTotal: 0,
  channelChart: {}
});

const queryParams = ref({
  chash: null,
  period: null
});

watch(queryParams, (after, before) => {
  setTimeout(() => {
    getChannelsReport();
  }, 2000)
}, {deep: true})

// let chartModel = ref({
//   height: 200,
// })

let setChartDataCheck = ref(0);

const getCardReport = async () => {
  internalInstance.appContext.config.globalProperties.$Progress.start();

  await store
    .dispatch('getCardReport')
    .then((res) => {
      let data = res.data

      model.value.today = data.today
      model.value.sevendays = data.last7Days
      model.value.thirtydays = data.last30Days
      model.value.total = data.total

      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
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

const getChannels = async () => {
  await store
    .dispatch('getChannelList')
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
      if(res.data.length){
        queryParams.value.chash = res.data[0]
        queryParams.value.period = model.value.period[0]
        getChannelsReport();
      }else{
        internalInstance.appContext.config.globalProperties.$Progress.finish();
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

const getChannelsReport = async () => {
  setChartDataCheck.value = 1;
  await store
    .dispatch('getChartReport', queryParams['_rawValue'])
    .then((res) => {
      let data = res.data;

      model.value.channelTotal = data.total;
      model.value.channelChart = data.chart;
      setChartDataCheck.value = 2;
      internalInstance.appContext.config.globalProperties.$Progress.finish();
    })
    .catch((err) => {
      setChartDataCheck.value = 2;
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

// const changeFilter = () => {
//   getChannelsReport();
// }

onMounted(() => {
  getCardReport();
  getChannels();
});

</script>

<style>

</style>