
<template>
  <div>
      <div>
        <img class="mx-auto h-12 w-auto" src="/neocast-brand-logo.png" alt="Workflow" />
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in </h2>
        
      </div>
      <form class="mt-8 space-y-6" @submit="login">
        <div v-if="errorMsg" class="flex items-center justify-between py-3 px-5 bg-red-500 text-white rounded">
          {{errorMsg}}
          <span @click="errorMsg = ''" 
            class="w-8 h-8 flex items-center justify-center rounded-full transition-color cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </span>
        </div>
        <input type="hidden" name="remember" value="true" />
        <div class="shadow-sm">
          <div class="relative z-0">
            <input type="email" id="email" v-model="user.email"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                placeholder=" " required="" />
            <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
          </div>
          <div class="relative z-0 mt-3">
            <input type="password" id="password" v-model="user.password"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                placeholder=" " required="" />
            <label for="password" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
            </div>
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember-me" name="remember-me" type="checkbox" v-model="user.remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
            <label for="remember-me" class="ml-2 block text-sm text-gray-900"> Remember me </label>
          </div>

          <div class="text-sm">
            <router-link :to="{name: 'ForgetPassword'}" class="font-medium text-indigo-600 hover:text-indigo-500"> Forgot your password? </router-link>
          </div>
        </div>

        <div>
          <button type="submit" 
            class="group relative w-full flex justify-center py-2 px-4 border 
            border-transparent text-sm font-medium text-white 
            bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
            </span>
            Sign in
          </button>
        </div>
      </form>
  </div>
</template>

<script setup>
import { LockClosedIcon } from '@heroicons/vue/solid'
import store from '../../store';
import { useRouter } from 'vue-router';
import { ref, getCurrentInstance } from 'vue';

const router = useRouter();
const internalInstance = getCurrentInstance();
const user = {
  email: '',
  password: '',
  remember: false
};

let errorMsg = ref('')

function login(ev) {
  ev.preventDefault();
  internalInstance.appContext.config.globalProperties.$Progress.start()
  store
    .dispatch('login', user)
    .then((res) => {
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      // check if user is active
      if(res.user.is_active == 1){
        videos();
      } else {
        logout();
      }
    })
    .catch(err => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      if(err.response){
        if (err.response.data.hasOwnProperty('message')){
          errorMsg.value = err.response.data.message
        }else {
          errorMsg.value = err.response.data.error
        }
      }
    })
}

function videos()
{
  store
    .dispatch('getContents')
    .then((res) => {
      if(res.data.length) {
        channel();
      }else {
        router.push({name: 'Welcomev'})
      }
    })
    .catch((err) => {
      
    });
}

function channel() {
  store
    .dispatch('getChannelList')
    .then((res) => {
      if(res.data.length) {
        router.push({name: 'Channels'})
      }else {
        router.push({name: 'Welcome'})
      }
    })
    .catch((err) => {
      
    });
}

function logout() {
    store.dispatch('logout')
    .then(() => {
      router.push({
        name: 'Login',
      });
    });
  }
</script>