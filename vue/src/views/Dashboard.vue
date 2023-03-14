<template>
    <div>
        <page-component title="Dashboard">
            <notification />
            <VideoSearch @searchVideo="searchVideo" @getVideos="getTrendingVideos"/>
            <VideoList :data="ytubeVideos.items" @saveVideo="saveVideo"/>
        </page-component>
    </div>
</template>

<script setup>
import { onMounted, computed, getCurrentInstance } from 'vue'
import PageComponent from '../components/PageComponent.vue'
import Notification from '../components/Notification.vue';
import VideoList from '../components/ytube/VideoList.vue'
import VideoSearch from '../components/ytube/VideoSearch.vue';
import ytubeStore from '../store/ytube-store';
import store from '../store';

const internalInstance = getCurrentInstance();
const ytubeVideos = computed(() => ytubeStore.state.videos)

function getTrendingVideos() {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    ytubeStore
        .dispatch('getTrendingVideos')
        .then(res => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
        })
        .catch(err => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
      
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

function searchVideo(videoId) {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    ytubeStore
        .dispatch('searchVideo', videoId)
        .then(res => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
        })
        .catch(err => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
      
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

function saveVideo(videoId, videoTitle) {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    ytubeStore
        .dispatch('saveVideo', {
            videoId: videoId,
            videoTitle: videoTitle
        })
        .then(res => {
            store.dispatch("setSuccessNotification", res.message);
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
        })
        .catch(err => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
      
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

onMounted(() => {
    getTrendingVideos();
})

</script>

<style>

</style>