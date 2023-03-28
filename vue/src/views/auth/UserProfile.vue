<template>
  <div>
    <page-component title="Profile Settings">
      <notification />
      <div class="grid xl:grid-cols-2 xl:gap-6">
        <!-- personal info section -->
        <div class="p-6 bg-white shadow-md dark:bg-gray-800 dark:border-gray-700 mb-3">
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
                focus:ring-0 focus:border-blue-600 peer" placeholder=" " required readonly />
              <label for="email"  
                class="peer-focus:font-medium absolute text-sm text-gray-500 
                dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 
                top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                peer-focus:-translate-y-6">Email address
              </label>
            </div>
            <div class="relative z-0 w-full mb-6 group mt-3">
              <input type="text" name="youtube"  v-model="user.youtube"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                border-0 border-b-2 border-gray-300 appearance-none dark:text-white 
                dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none 
                focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
              <label for="youtube"  
                class="peer-focus:font-medium absolute text-sm text-gray-500 
                dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 
                top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                peer-focus:-translate-y-6">Youtube API Key
              </label>
              <p class="text-gray-500 bg-gray-100 p-2 mt-2">
                Generate Youtube API Key 
                <router-link :to="{name: 'Article', params: {name: '2-Generate-Youtube-API-Key'}}"
                  class="text-extrabold font-medium text-blue-500 underline"
                  target="_blank">
                  Learn More
                </router-link>
              </p>
            </div>
            <button type="submit" class="group relative flex justify-center py-2 px-4 
              border border-transparent text-sm font-medium text-white float-right
              bg-indigo-600 hover:bg-indigo-700 focus:outline-none" :disabled="isDisabled">Submit
            </button>
          </form>
        </div>
        <!-- change password section -->
        
        <div class="p-6 bg-white shadow-md dark:bg-gray-800 dark:border-gray-700 mb-3">
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
import { ref, getCurrentInstance, onMounted, computed, watch } from 'vue'

const profile = computed(() => store.state.profile)
const internalInstance = getCurrentInstance();
const user = ref({
  name: null,
  email: null,
  youtube: '',
});
const userPass = {
  current_password: '',
  new_password: '',
  confirm_password: '',
}

watch(profile, (newVal, oldVal) => {
  user.value.name = newVal.name;
  user.value.email = newVal.email;
  user.value.youtube = newVal.youtube;
}, {deep:true})

if (user){
  user.value = store.state.user.data
}

let isDisabled = ref(false);

function updatePersonalInfo(ev) {
  ev.preventDefault();
  // progress bar start
  internalInstance.appContext.config.globalProperties.$Progress.start();
  isDisabled.value = true;

  store
    .dispatch('updatePersonalInfo', {
      name: user.value.name,
      email: user.value.email,
      youtube: user.value.youtube
    })
    .then((res) => {
      // progress bar start
      internalInstance.appContext.config.globalProperties.$Progress.finish();
      isDisabled.value = false;
      store.dispatch("setSuccessNotification", res.status);
    })
    .catch(err => {
      // progress bar start
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      isDisabled.value = false;

      if(err.response.data){
        if (err.response.data.hasOwnProperty('message')){
          store.dispatch("setErrorNotification", err.response.data.message);
        }else {
          store.dispatch("setErrorNotification", err.response.data.error);
        }
      }
    })
}

function updatePassword(ev) {
  ev.preventDefault();
  if (userPass.new_password !==  userPass.confirm_password) {;
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
        store.dispatch("setSuccessNotification", res.status);
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
            store.dispatch("setErrorNotification", err.response.data.message);
          }else {
            store.dispatch("setErrorNotification", err.response.data.error);
          }
        }
      })
  }
}

onMounted(() => {
  store.dispatch('profile')
})
</script>

<style>

</style>