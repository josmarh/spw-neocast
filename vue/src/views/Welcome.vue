<template>
    <div>
        <Welcome>
        <div class="flex justify-center items-center">
          <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-2xl text-gray-900 dark:text-white">Hi! Your channels list looks empty. Create your first channel now.</h5>
            <div class="flex justify-center items-center mt-6">
              <router-link
                :to="{ name: 'CreateChannel' }"
                class="
                  group
                  relative
                  flex
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
                Create channel
              </router-link>
            </div>
            <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
              <img src="../assets/no_channel.png" class="xl:w-82 xl:h-82" />
            </div>
          </div>
        </div>
        </Welcome>
    </div>
</template>

<script setup>
import Welcome from '../components/Welcome.vue';

</script>

<style>

</style>