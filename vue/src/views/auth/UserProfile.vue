<template>
  <div>
    <page-component title="Profile Settings">
      <notification />
      <!-- <div v-if="successMsg">
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
      </div> -->

      <div class="grid xl:grid-cols-2 xl:gap-6">
        <!-- personal info section -->
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 mb-3">
          <h3 class="font-bold">Personal Information</h3>
          <p class="mb-6">Update your account's profile information and email address.</p>
          <form @submit="updatePersonalInfo">
            
            <div class="relative z-0 w-full mb-6 group mt-3">
              <input type="text" name="username" v-model="user.name"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                border-0 border-b-2 border-gray-300 appearance-none dark:text-white 
                dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none 
                focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
              <label for="username"  
                class="peer-focus:font-medium absolute text-sm text-gray-500 
                dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 
                top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                peer-focus:-translate-y-6">Name
              </label>
            </div>
            <div class="relative z-0 w-full mb-6 group mt-3">
              <input type="email" name="email"  v-model="user.email"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                border-0 border-b-2 border-gray-300 appearance-none dark:text-white 
                dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none 
                focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
              <label for="email"  
                class="peer-focus:font-medium absolute text-sm text-gray-500 
                dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 
                top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                peer-focus:-translate-y-6">Email address
              </label>
            </div>
            <button type="submit" class="group relative flex justify-center py-2 px-4 
              border border-transparent text-sm font-medium text-white float-right
              bg-indigo-600 hover:bg-indigo-700 focus:outline-none" :disabled="isDisabled">Submit
            </button>
          </form>
        </div>
        <!-- change password section -->
        
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 mb-3">
          <h3 class="font-bold">Update Password</h3>
          <p class="mb-6">Ensure your account is using a long, random password to stay secure.</p>
          <form @submit="updatePassword">
            <div class="relative z-0 w-full mb-6 mt-3 group">
              <input type="password" name="current_password" id="current_password" v-model="userPass.current_password"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 
                border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 
                peer" placeholder=" " required="">
              <label for="current_password" 
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 
                duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 
                peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Current Password</label>
            </div>
            <div class="relative z-0 w-full mb-6 group">
              <input type="password" name="new_password" id="new_password" v-model="userPass.new_password"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 
                border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 
                focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
              <label for="new_password" 
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                peer-focus:scale-75 peer-focus:-translate-y-6">New Password</label>
            </div>
            <div class="relative z-0 w-full mb-6 group">
              <input type="password" name="confirm_password" id="confirm_password" v-model="userPass.confirm_password"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 
                border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 
                peer" placeholder=" " required="">
              <label for="confirm_password" 
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 
                duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 
                peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm New password</label>
            </div>
            <button type="submit" id="update-pass-btn"
              class="group relative flex justify-center py-2 px-4 
              border border-transparent text-sm font-medium text-white float-right
              bg-indigo-600 hover:bg-indigo-700 focus:outline-none" :disabled="isDisabled">Submit
            </button>
          </form>
        </div>
      </div>
    </page-component>
  </div>
</template>

<script setup>
import PageComponent from '../../components/PageComponent.vue'
import Notification from '../../components/Notification.vue';
import store from '../../store'
import { ref, getCurrentInstance } from 'vue'

const internalInstance = getCurrentInstance();
const user = ref({
  name: null,
  email: null
});
const userPass = {
  current_password: '',
  new_password: '',
  confirm_password: '',
}

if (user){
  user.value = store.state.user.data
}

let errorMsg = ref('');
let successMsg = ref('');
let isDisabled = ref(false);

function updatePersonalInfo(ev) {
  ev.preventDefault();
  // progress bar start
  internalInstance.appContext.config.globalProperties.$Progress.start();
  isDisabled.value = true;

  store
    .dispatch('updatePersonalInfo', {
      name: user.value.name,
      email: user.value.email
    })
    .then((res) => {
      // progress bar start
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      isDisabled.value = false;
      // successMsg.value = res.status;
    })
    .catch(err => {
      // progress bar start
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      isDisabled.value = false;

      if(err.response.data){
        if (err.response.data.hasOwnProperty('message')){
          // errorMsg.value = err.response.data.message
          store.dispatch("setErrorNotification", err.response.data.message);
        }else {
          // errorMsg.value = err.response.data.error
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    })
}

function updatePassword(ev) {
  ev.preventDefault();
  if (userPass.new_password !==  userPass.confirm_password) {
    // errorMsg.value = 'Password does not match';
    store.dispatch("setErrorNotification", 'Password does not match');
    return false;
  }else{
    // progress bar start
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;

    store
      .dispatch('updatePassword', userPass)
      .then((res) => {
        internalInstance.appContext.config.globalProperties.$Progress.finish();
        successMsg.value = res.status;
        userPass.current_password = '';
        userPass.new_password = '';
        userPass.confirm_password = '';
        isDisabled.value = false;
      })
      .catch(err => {
        internalInstance.appContext.config.globalProperties.$Progress.fail();
        isDisabled.value = false;

        if(err.response.data) {
          if (err.response.data.hasOwnProperty('message')){
            // errorMsg.value = err.response.data.message
            store.dispatch("setErrorNotification", err.response.data.message);
          }else {
            // errorMsg.value = err.response.data.error
            store.dispatch("setErrorNotification", err.response.data.error);
          }
        }
      })
  }
}
</script>

<style>

</style>