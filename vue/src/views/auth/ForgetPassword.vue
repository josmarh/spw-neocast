
<template>
  <div>
    <div>
      <img class="mx-auto h-12 w-auto" :src="appUrl + '/smatflix-brand-logo.png'" alt="Workflow" />
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Forgot Password</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        <!-- Or
        {{ ' ' }}
        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"> start your 14-day free trial </a> -->
      </p>
    </div>
    <form class="mt-12 space-y-6" @submit.prevent="resetPassword">
      <div v-if="config.errorMsg" class="flex items-center justify-between py-3 px-5 bg-red-500 text-white rounded">
        {{config.errorMsg}}
        <span @click="config.errorMsg = ''" 
          class="w-8 h-8 flex items-center justify-center rounded-full transition-color cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </span>
      </div>
      <div v-if="config.successMsg" class="flex items-center justify-between py-3 px-5 bg-green-500 text-white rounded">
        {{config.successMsg}}
        <span @click="config.successMsg = ''" 
          class="w-8 h-8 flex items-center justify-center rounded-full transition-color cursor-pointer hover:bg-green-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </span>
      </div>
      <div class="shadow-sm">
          <div class="relative z-0">
              <input type="email" id="email" v-model="email"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 
                bg-transparent border-0 border-b-2 border-gray-300 
                appearance-none dark:text-white dark:border-gray-600 
                dark:focus:border-blue-500 focus:outline-none focus:ring-0 
                focus:border-blue-600 peer" placeholder=" " required=" " />
              <label for="email" 
                class="absolute text-sm text-gray-500 dark:text-gray-400 
                duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                peer-focus:-translate-y-6">Email
              </label>
          </div>
      </div>
      <div>
        <button type="submit"
          class="group relative w-full flex justify-center py-2 px-4 border 
          border-transparent text-sm font-medium text-white 
          bg-indigo-600 hover:bg-indigo-700 focus:outline-none"
          :disabled="config.isDisabled">
          Submit
        </button>
      </div>
      <div class="flex items-center justify-between">
        <div class="flex items-center">
        </div>

        <div class="text-sm">
          <router-link :to="{name: 'Login'}" 
            class="font-medium text-indigo-600 
            hover:text-indigo-500 cursor-pointer">Login
          </router-link>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import store from '../../store';
import { ref, getCurrentInstance } from 'vue';
import { useRouter } from 'vue-router';

const appUrl = import.meta.env.VITE_APP_URI
const router = useRouter();
let email = ref('');

const config = ref({
  errorMsg: '',
  successMsg: '',
  isDisabled: false
});
const internalInstance = getCurrentInstance();

const resetPassword = () => {
  config.value.isDisabled = true;
  internalInstance.appContext.config.globalProperties.$Progress.start();

  store
    .dispatch('forgotPassword', {email: email['_rawValue']})
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      config.value.successMsg = res.message;
      config.value.isDisabled = false;
      setTimeout(() => {
        router.push({name: 'ResetPassword', params: {email: email.value}});
      }, 3000);
    })
    .catch((err) => {
      config.value.isDisabled = false;
      internalInstance.appContext.config.globalProperties.$Progress.fail();

      if(err.response){
        if (err.response.data.hasOwnProperty('message')){
          config.value.errorMsg = err.response.data.message
        }else {
          config.value.errorMsg = err.response.data.error
        }
      }
    })
}
</script>