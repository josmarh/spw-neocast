
<template>
  <div>
    <div>
      <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Reset Password</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        <!-- Or
        {{ ' ' }}
        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"> start your 14-day free trial </a> -->
      </p>
    </div>
    <form class="mt-8 space-y-6" action="#" method="POST">
      <input type="hidden" name="remember" value="true" />
      <div class="shadow-sm">
          <div class="relative z-0">
              <input type="email" id="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required=" " />
              <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
          </div>
      </div>
      <div class="flex items-center justify-between">
        <div class="flex items-center">
        </div>

        <div class="text-sm">
          <router-link :to="{name: 'Login'}" class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer">Login</router-link>
        </div>
      </div>

      <div>
        <button type="submit" 
          class="group relative w-full flex justify-center py-2 px-4 border 
          border-transparent text-sm font-medium text-white 
          bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
          Reset
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>

</script>