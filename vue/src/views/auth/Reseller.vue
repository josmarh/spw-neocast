<template>
    <div>
        <div>
            <img class="mx-auto h-12 w-auto" src="/neocast-brand-logo.png" alt="Workflow" />
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in </h2>
        </div>
        <form class="mt-8 space-y-6" @submit.prevent="register">
            <div v-if="config.errorMsg" class="flex items-center justify-between py-3 px-5 bg-red-500 text-white rounded">
                {{config.errorMsg}}
                <span @click="config.errorMsg = ''" 
                    class="w-8 h-8 flex items-center justify-center rounded-full transition-color cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>
            <div v-else-if="config.successMsg" class="flex items-center justify-between py-3 px-5 bg-green-500 text-white rounded">
                {{config.successMsg}}
                <span @click="config.successMsg = ''" 
                    class="w-8 h-8 flex items-center justify-center rounded-full transition-color cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>
            <div class="shadow-sm">
                <div class="relative z-0">
                    <input type="text" id="name" v-model="model.name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                        border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                        dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                        placeholder=" " required="" 
                    />
                    <label for="name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                        transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                        peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                        peer-focus:scale-75 peer-focus:-translate-y-6">Full name
                    </label>
                </div>
                <div class="relative z-0 mt-4">
                    <input type="email" id="email" v-model="model.email"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                        border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                        dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                        placeholder=" " required="" />
                    <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                        transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                        peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                        peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                </div>
                <div class="relative z-0 mt-4">
                    <input type="password" id="password" v-model="model.password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                        border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                        dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                        placeholder=" " required="" />
                    <label for="password" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                        transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                        peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                    peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                </div>
                <div class="relative z-0 mt-4">
                    <input type="password" id="confirm_password" v-model="model.password_confirmation"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                        border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                        dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                        placeholder=" " required="" 
                    />
                    <label for="confirm_password" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                        transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                        peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                        peer-focus:scale-75 peer-focus:-translate-y-6">Confirm Password
                    </label>
                </div>
            </div>
            <div>
                <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border 
                border-transparent text-sm font-medium text-white 
                bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                Register
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, getCurrentInstance } from 'vue';
import { useRouter } from 'vue-router';
import resellerStore from '../../store/reseller-store';

const router = useRouter()
const internalInstance = getCurrentInstance();
const config = ref({
    errorMsg: '',
    successMsg: '',
    isDisabled: false
})
const model = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const register = () => {
    config.value.isDisabled = true
    internalInstance.appContext.config.globalProperties.$Progress.start()
    resellerStore
        .dispatch('register',model.value)
        .then(res => {
            config.value.isDisabled = false
            config.value.successMsg = res.message
            internalInstance.appContext.config.globalProperties.$Progress.finish();

            setTimeout(() => {
                router.push({
                    name: 'Login'
                })
            },1500)
        })
        .catch(err => {
            config.value.isDisabled = false
            internalInstance.appContext.config.globalProperties.$Progress.fail();

            if (err.response.data.hasOwnProperty('message')) {
                config.value.errorMsg = err.response.data.message
            }else {
                config.value.errorMsg = err.response.data.error
            }
        })
}
</script>

<style>

</style>