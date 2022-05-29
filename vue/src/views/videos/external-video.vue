<template>
    <div>
        <vue-progress-bar></vue-progress-bar>
        <div class="py-6 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <p class="mt-2 xl:text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        {{data.filename}}
                    </p>
                </div>
                <div v-if="data.fileurl !== null" class="mt-10  xl:h-[40rem]">
                    <!-- audio element -->
                    <vue-plyr v-if="data.filename.includes('.mp3')">
                        <audio controls playsinline >
                        <source
                            :src="data.fileurl"
                            type="audio/mp3"
                            class="pt-20"
                        />
                        </audio>
                    </vue-plyr>
                    <!-- video element -->
                    <vue-plyr v-else :options="options">
                        <video
                        controls
                        playsinline
                        data-poster=""
                        >
                        <source
                            size="720"
                            :src="data.fileurl"
                            type="video/mp4"
                        />
                        <source
                            size="1080"
                            :src="data.fileurl"
                            type="video/mp4"
                        />
                        </video>
                    </vue-plyr>
                </div>
                <div v-if="contentCheck == true" class="flex justify-center items-center mt-12">
                    <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="text-2xl text-gray-900 dark:text-white">No content found</h5>
                    <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                        <img src="../../assets/no_content.png" class="xl:w-82 xl:h-82" />
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import store from "../../store";
import { ref, onMounted, getCurrentInstance, computed } from "vue";
import { useRouter, useRoute } from 'vue-router';

const internalInstance = getCurrentInstance();
const content = computed(() => store.state.externalContent);
const router = useRouter();
const route = useRoute();

let contentCheck = ref(false)
let errorMsg = ref("");
let data = ref({
    filename: null,
    fileurl: null,
})

// Get param contents 
const getExternalContent = async () => {
  internalInstance.appContext.config.globalProperties.$Progress.start();
  await store
    .dispatch("getExternalContent", route.params.str)
    .then((res) => {
        internalInstance.appContext.config.globalProperties.$Progress.finish();
        data.value.filename = res.content.file_name
        data.value.fileurl = res.content.file_hash
        if (data.value.fileurl == null){
            contentCheck.value = true
        }
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();
      contentCheck.value = true

      if (err.response.data) {
        if (err.response.data.hasOwnProperty("message")) {
          errorMsg.value = err.response.data.message;
        } else {
          errorMsg.value = err.response.data.error;
        }
      }
    });
};

onMounted(() => {
  getExternalContent();
});
</script>

<style>

</style>