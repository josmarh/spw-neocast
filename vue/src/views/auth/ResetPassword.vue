
<template>
  <div>
    <div>
      <img class="mx-auto h-12 w-auto" src="/neocast-brand-logo.png" alt="Workflow" />
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Reset Password</h2>
      <p class="mt-2 text-center text-sm text-gray-600"></p>
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
                <input type="number" id="verification_code" v-model="user.verification_code"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 
                    bg-transparent border-0 border-b-2 border-gray-300 
                    appearance-none dark:text-white dark:border-gray-600
                    dark:focus:border-blue-500 focus:outline-none focus:ring-0 
                    focus:border-blue-600 peer" placeholder=" " required=" " />
                <label for="verification_code" 
                    class="absolute text-sm text-gray-500 dark:text-gray-400 
                    duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                    origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                    peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                    peer-focus:-translate-y-6">Verification Code
                </label>
            </div>
            <div class="relative z-0 mt-6">
                <input type="password" id="password" v-model="user.password"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 
                    bg-transparent border-0 border-b-2 border-gray-300 
                    appearance-none dark:text-white dark:border-gray-600
                    dark:focus:border-blue-500 focus:outline-none focus:ring-0 
                    focus:border-blue-600 peer" placeholder=" " required=" " />
                <div v-if="user.password" 
                    class="flex absolute inset-y-0 right-0 items-center pr-3  cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" @click="showPassword('password')"
                        class="h-5 w-6 text-gray-600 dark:text-gray-400 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <label for="password" 
                    class="absolute text-sm text-gray-500 dark:text-gray-400 
                    duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                    origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                    peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                    peer-focus:-translate-y-6">Password
                </label>
            </div>
            <div class="relative z-0 mt-6">
                <input
                    type="password"
                    id="password_confirmation"
                    v-model="user.password_confirmation"
                    class="block py-2 px-0 xl:w-full sm:w-full
                    text-sm text-gray-900 bg-transparent
                    border-0 border-b-2 border-gray-300
                    appearance-none dark:text-white dark:border-gray-600
                    dark:focus:border-blue-500 focus:outline-none 
                    focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " />
                <div v-if="user.password_confirmation"  class="flex absolute inset-y-0 right-0 items-center pr-3 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" @click="showPassword('password_confirmation')"
                        class="h-5 w-6 text-gray-600 dark:text-gray-400 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <label
                    for="password_confirmation"
                    class="absolute text-sm text-gray-500 dark:text-gray-400
                    duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                    origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                    peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                    peer-focus:-translate-y-6 "
                    >Confirm Password
                </label>
            </div>
        </div>
        <div>
            <button type="submit"
            class="group relative w-full flex justify-center py-2 px-4 border 
            border-transparent text-sm font-medium text-white 
            bg-indigo-600 hover:bg-indigo-700 focus:outline-none"
            :disabled="config.isDisabled">
            Reset
            </button>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center text-sm">
                <router-link :to="{name: 'ForgetPassword'}" 
                    class="font-medium text-indigo-600 
                    hover:text-indigo-500 cursor-pointer">Resend Verification Code
                </router-link>
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
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

let user = ref({
    email: route.params.email,
    password: '',
    password_confirmation: '',
    verification_code: null,
});
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
    .dispatch('resetPassword', user.value)
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      config.value.successMsg = res.message;
      config.value.isDisabled = false;
      setTimeout(() => {
        router.push({name: 'Login'});
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

const showPassword = (elm) => {
    let passElm = document.getElementById(elm);
    if(passElm.value !== ''){
        if (passElm.getAttribute('type') == 'password') {
            passElm.setAttribute('type', 'text');
        } else {
            passElm.setAttribute('type', 'password');
        }
    }
}
</script>