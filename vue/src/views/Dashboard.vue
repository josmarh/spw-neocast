<template>
    <div>
        <page-component title="Dashboard" @updateView="updateView">
            <notification />
            <div :class="[currentView === 'youtube' ? 'block':'hidden']">
                <VideoSearch @searchVideo="searchVideo" @getVideos="getTrendingVideos"/>
                <VideoList :data="ytubeVideos.items" @saveVideo="saveVideo"/>
            </div>
            <div :class="[currentView === 'iptv' ? 'block':'hidden']">
                <Iptv 
                :data="iptvChannels.data"
                :meta="iptvChannels.meta"
                :categories="iptvCategories.data"
                @paginate="paginateIptvChannel"
                @categoryFilter="iptvCategoryFilter"/>
            </div>
        </page-component>
    </div>
</template>

<script setup>
import { onMounted, computed, getCurrentInstance, ref } from 'vue'
import PageComponent from '../components/PageComponent.vue'
import Notification from '../components/Notification.vue';
import VideoList from '../components/ytube/VideoList.vue'
import VideoSearch from '../components/ytube/VideoSearch.vue';
import Iptv from '../components/ytube/Iptv.vue'
import ytubeStore from '../store/ytube-store';
import store from '../store';

const internalInstance = getCurrentInstance();
const ytubeVideos = computed(() => ytubeStore.state.videos)
const iptvChannels = computed(() => ytubeStore.state.iptvChannels)
const iptvCategories = computed(() => ytubeStore.state.iptvCategories)

let currentView = ref('youtube')

function updateView(view){
    currentView.value = view
}

function getTrendingVideos() {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    ytubeStore
        .dispatch('getTrendingVideos')
        .then(res => {
            internalInstance.appContext.config.globalProperties.$Progress.finish();
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

function searchVideo(video) {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    ytubeStore
        .dispatch('searchVideo', video)
        .then(res => {
            internalInstance.appContext.config.globalProperties.$Progress.finish();
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
            internalInstance.appContext.config.globalProperties.$Progress.finish();
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

function iptvCategoryFilter(category){
    ytubeStore
        .dispatch('filterIptvChannelCategory', {category: category})
        .then(() => {})
        .catch(err => {
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

function paginateIptvChannel(url){
    ytubeStore.dispatch("getIptvChannels", url)
    window.scroll(0,0)
}

onMounted(() => {
    getTrendingVideos();
    ytubeStore.dispatch('getIptvChannels')
    ytubeStore.dispatch('getIptvCategories')
})

</script>

<style>

</style>