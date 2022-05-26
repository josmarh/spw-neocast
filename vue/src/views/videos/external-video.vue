<template>
    <div>
        <vue-progress-bar></vue-progress-bar>
        <div class="py-6 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        {{data.filename}}
                    </p>
                </div>
                <div v-if="data.fileurl !== null" class="mt-10  h-[40rem] ">
                    <vue-plyr :options="options">
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
    })
    .catch((err) => {
      internalInstance.appContext.config.globalProperties.$Progress.fail();

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