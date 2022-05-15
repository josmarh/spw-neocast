
<template>
  <div>
    <div>
      <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign up </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        <!-- Or
        {{ ' ' }}
        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"> start your 14-day free trial </a> -->
      </p>
    </div>
    <form class="mt-8 space-y-6" @submit="register">
      <input type="hidden" name="remember" value="true"  />
      <div class="shadow-sm">
          <div class="relative z-0">
              <input type="text" id="name" v-model="user.name"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                  border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                  dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                  placeholder=" " required="" 
              />
              <label for="name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                  transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                  peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                  peer-focus:scale-75 peer-focus:-translate-y-6">Full Name
              </label>
          </div>
          <div class="relative z-0 mt-3">
              <input type="email" id="email" v-model="user.email"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                  border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                  dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                  placeholder=" " required="" 
              />
              <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                  transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                  peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                  peer-focus:scale-75 peer-focus:-translate-y-6">Email
              </label>
          </div>
          <div class="relative z-0 mt-3">
              <input type="password" id="password" v-model="user.password"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent 
                  border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 
                  dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                  placeholder=" " required="" 
              />
              <label for="password" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 
                  transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                  peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                  peer-focus:scale-75 peer-focus:-translate-y-6">Password
              </label>
          </div>
          <div class="relative z-0 mt-3">
              <input type="password" id="confirm_password" v-model="user.password_confirmation"
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
          <!-- <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
          </span> -->
          Register
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import store from '../../store'
import { useRouter } from 'vue-router'

const router = useRouter();
const user = {
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
};

function register(ev) {
  ev.preventDefault();
  store
    .dispatch('register', user)
    .then((res) => {
      router.push({name: 'Dashboard'})
    })
}
</script>