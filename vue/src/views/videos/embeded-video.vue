<template>
    <div>
        <div v-if="data.fileurl !== null" class="h-screen">
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
    </div>
</template>

<script setup>
import store from "../../store";
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();

let data = ref({
    filename: null,
    fileurl: null,
})

// Get param contents 
const getExternalContent = async () => {
  await store
    .dispatch("getExternalContent", route.params.str)
    .then((res) => {
        data.value.filename = res.content.file_name
        data.value.fileurl = res.content.file_hash
    })
    .catch((err) => {
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